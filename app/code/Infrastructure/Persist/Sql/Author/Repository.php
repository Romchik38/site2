<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Author;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\DatabaseTransactionException;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Author\AuthorService\Exceptions\NoSuchAuthorException;
use Romchik38\Site2\Application\Author\AuthorService\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Author\AuthorService\RepositoryInterface;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Author\Author;
use Romchik38\Site2\Domain\Author\Entities\Translate;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Description;
use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function count;
use function json_decode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function getById(AuthorId $id): Author
    {
        $params = [$id()];
        $query  = $this->defaultSelectQuery();

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $rowsCount = count($rows);
        if ($rowsCount === 0) {
            throw new NoSuchAuthorException(sprintf(
                'Author with is %s not exist',
                $id()
            ));
        }
        if ($rowsCount > 1) {
            throw new RepositoryException(sprintf(
                'Author with is %s has duplicates',
                $id()
            ));
        }

        return $this->createFromRow($rows[0]);
    }

    public function delete(Author $model): void
    {
        $id = $model->identifier;
        if ($id === null) {
            throw new RepositoryException('Could not delete author - id not set');
        }
        $query  = $this->mainDeleteQuery();
        $params = [(string) $id];

        // Do not need delete translates, because they will be deleted cascade
        try {
            $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }

    public function save(Author $model): Author
    {
        $authorId = $model->identifier;
        if ($authorId === null) {
             throw new RepositoryException('Could not save author - param id not set');
        }

        $authorName = $model->getName();
        if ($model->active) {
            $authorActive = 't';
        } else {
            $authorActive = 'f';
        }

        $mainSaveQuery = $this->mainSaveQuery();
        $mainParams    = [$authorName(), $authorActive, $authorId()];

        $translates = $model->getTranslates();

        try {
            $this->database->transactionStart();
            $this->database->queryParams(
                $mainSaveQuery,
                $mainParams
            );
            $this->database->queryParams(
                $this->translatesSaveQueryDelete(),
                [$authorId()]
            );
            foreach ($translates as $translate) {
                $this->database->queryParams(
                    $this->translatesSaveQueryInsert(),
                    [
                        $authorId(),
                        (string) $translate->getLanguage(),
                        (string) $translate->getDescription(),
                    ]
                );
            }
            $this->database->transactionEnd();
        } catch (DatabaseTransactionException $e) {
            try {
                $this->database->transactionRollback();
                throw new RepositoryException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new RepositoryException($e2->getMessage());
            }
        } catch (QueryException $e) {
            try {
                $this->database->transactionRollback();
                throw new RepositoryException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new RepositoryException($e2->getMessage());
            }
        }
        return $this->getById($authorId);
    }

    public function add(Author $model): AuthorId
    {
        $authorName = $model->getName();
        if ($model->active) {
            $authorActive = 't';
        } else {
            $authorActive = 'f';
        }

        $mainParams = [$authorName(), $authorActive];

        $translates = $model->getTranslates();

        try {
            $this->database->transactionStart();
            $rowsMainAdd = $this->database->queryParams(
                $this->mainAddQuery(),
                $mainParams
            );
            if (count($rowsMainAdd) !== 1) {
                throw new RepositoryException('Main add query must return 1 row');
            }
            $rawAuthorId = $rowsMainAdd[0]['identifier'] ?? null;
            if ($rawAuthorId === null) {
                throw new RepositoryException('Main add query does not return identifier');
            }

            foreach ($translates as $translate) {
                $this->database->queryParams(
                    $this->translatesSaveQueryInsert(),
                    [
                        $rawAuthorId,
                        (string) $translate->getLanguage(),
                        (string) $translate->getDescription(),
                    ]
                );
            }
            $this->database->transactionEnd();
        } catch (DatabaseTransactionException $e) {
            try {
                $this->database->transactionRollback();
                throw new RepositoryException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new RepositoryException($e2->getMessage());
            }
        } catch (QueryException $e) {
            try {
                $this->database->transactionRollback();
                throw new RepositoryException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new RepositoryException($e2->getMessage());
            }
        }
        return AuthorId::fromString($rawAuthorId);
    }

    /** @param array<string,string|null> $row */
    private function createFromRow(array $row): Author
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Author id is invalid');
        }

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Author name is invalid');
        }

        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Author active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        // languages
        $rawLanguages = $row['languages'] ?? null;
        if ($rawLanguages === null) {
            throw new RepositoryException('Author languages param is invalid');
        }
        $languages = $this->prepareRawLanguages($rawLanguages);

        // articles
        $rawArticles = $row['articles'] ?? null;
        if ($rawArticles === null) {
            throw new RepositoryException('Author articles param is invalid');
        }
        $articles = $this->prepareRawArticles($rawArticles);

        // images
        $rawImages = $row['images'] ?? null;
        if ($rawImages === null) {
            throw new RepositoryException('Author images param is invalid');
        }
        $images = $this->prepareRawImages($rawImages);

        // translates
        $translates = $this->createTranslates($rawIdentifier);

        try {
            $id   = AuthorId::fromString($rawIdentifier);
            $name = new Name($rawName);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        // create a model
        return new Author(
            $id,
            $name,
            $active,
            $articles,
            $images,
            $languages,
            $translates
        );
    }

    /** @return array<int,Translate> */
    private function createTranslates(string $authorId): array
    {
        $translates = [];

        $params = [$authorId];
        $query  = $this->translatesQuery();

        $rows = $this->database->queryParams($query, $params);

        foreach ($rows as $row) {
            $rawLanguage = $row['language'] ?? null;
            if ($rawLanguage === null) {
                throw new RepositoryException('Author translates language param is invalid');
            }
            $rawDescription = $row['description'] ?? null;
            if ($rawDescription === null) {
                throw new RepositoryException('Author translates description param is invalid');
            }
            try {
                $languageId  = new LanguageId($rawLanguage);
                $description = new Description($rawDescription);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
            $translates[] = new Translate($languageId, $description);
        }

        return $translates;
    }

    /**
     * @param string $rawImages - Json encoded array of strings
     * @return array<int,ImageId>
     */
    private function prepareRawImages(string $rawImages): array
    {
        $decodedImages = json_decode($rawImages);

        $data = [];
        foreach ($decodedImages as $image) {
            try {
                $data[] = new ImageId($image);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
        }
        return $data;
    }

        /**
         * @param string $rawArticles - Json encoded array of strings
         * @return array<int,ArticleId>
         */
    private function prepareRawArticles(string $rawArticles): array
    {
        $decodedArticles = json_decode($rawArticles);

        $data = [];
        foreach ($decodedArticles as $article) {
            try {
                $data[] = new ArticleId($article);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
        }
        return $data;
    }

    /**
     * @param string $rawLanguages - Json encoded array of strings
     * @return array<int,LanguageId>
     */
    private function prepareRawLanguages(string $rawLanguages): array
    {
        $decodedLanguages = json_decode($rawLanguages);

        $data = [];
        foreach ($decodedLanguages as $language) {
            try {
                $data[] = new LanguageId($language);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
        }
        return $data;
    }

    private function defaultSelectQuery(): string
    {
        return <<<'QUERY'
        SELECT author.identifier,
            author.name,
            author.active,
            array_to_json (
                array (SELECT language.identifier 
                    FROM language
                ) 
            ) as languages,
            array_to_json (
                array (SELECT article.identifier 
                    FROM article
                    WHERE article.author_id = $1
                ) 
            ) as articles,
            array_to_json (
                array (SELECT img.identifier 
                    FROM img
                    WHERE img.author_id = $1
                ) 
            ) as images
        FROM author
        WHERE author.identifier = $1
        QUERY;
    }

    private function translatesQuery(): string
    {
        return <<<'QUERY'
        SELECT author_translates.language,
            author_translates.description
        FROM author_translates
        WHERE author_translates.author_id = $1
        QUERY;
    }

    private function mainSaveQuery(): string
    {
        return <<<'QUERY'
        UPDATE author 
        SET name = $1, active = $2
        WHERE identifier = $3
        QUERY;
    }

    private function translatesSaveQueryDelete(): string
    {
        return <<<'QUERY'
        DELETE FROM author_translates 
        WHERE author_id = $1
        QUERY;
    }

    private function translatesSaveQueryInsert(): string
    {
        return <<<'QUERY'
        INSERT INTO author_translates (author_id, language, description)
            VALUES ($1, $2, $3)
        QUERY;
    }

    private function mainAddQuery(): string
    {
        return <<<'QUERY'
        INSERT INTO author (name, active)
        VALUES ($1, $2)
        RETURNING identifier;
        QUERY;
    }

    private function mainDeleteQuery(): string
    {
        return <<<'QUERY'
        DELETE FROM author 
        WHERE identifier = $1
        QUERY;
    }
}
