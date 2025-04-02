<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Author;

use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Server\Models\Sql\DatabaseTransactionException;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Author\Author;
use Romchik38\Site2\Domain\Author\CouldDeleteException;
use Romchik38\Site2\Domain\Author\CouldNotSaveException;
use Romchik38\Site2\Domain\Author\Entities\Translate;
use Romchik38\Site2\Domain\Author\NoSuchAuthorException;
use Romchik38\Site2\Domain\Author\RepositoryException;
use Romchik38\Site2\Domain\Author\RepositoryInterface;
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
        $query  = $this->mainDeleteQuery();
        $params = [(string) $model->getId()];

        // Do not need delete translates, because they will be deleted cascade
        try {
            $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new CouldDeleteException($e->getMessage());
        }
    }

    public function save(Author $model): Author
    {
        $authorId = $model->getId();
        if ($authorId === null) {
            return $this->add($model);
        }

        $authorName = $model->getName();
        if ($model->isActive()) {
            $authorActive = 't';
        } else {
            $authorActive = 'f';
        }

        $mainSaveQuery = $this->mainSaveQuery();
        $mainParams    = [$authorName(), $authorActive, $authorId()];

        $translates      = $model->getTranslates();
        $translatetItems = [];
        foreach ($translates as $translate) {
            $translatetItems[] = sprintf(
                '(%s, \'%s\', \'%s\')',
                $authorId(),
                (string) $translate->getLanguage(),
                (string) $translate->getDescription()
            );
        }

        try {
            $this->database->transactionStart();
            $this->database->transactionQueryParams(
                $mainSaveQuery,
                $mainParams
            );
            $this->database->transactionQueryParams(
                $this->translatesSaveQueryDelete(),
                [$authorId()]
            );
            foreach ($translates as $translate) {
                $this->database->transactionQueryParams(
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
                throw new CouldNotSaveException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new CouldNotSaveException($e2->getMessage());
            }
        } catch (QueryException $e) {
            try {
                $this->database->transactionRollback();
                throw new CouldNotSaveException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new CouldNotSaveException($e2->getMessage());
            }
        }
        return $this->getById($authorId);
    }

    /** @throws CouldNotSaveException */
    protected function add(Author $model): Author
    {
        $authorName = $model->getName();
        if ($model->isActive()) {
            $authorActive = 't';
        } else {
            $authorActive = 'f';
        }

        $mainParams = [$authorName(), $authorActive];

        $translates = $model->getTranslates();

        try {
            $this->database->transactionStart();
            $rowsMainAdd = $this->database->transactionQueryParams(
                $this->mainAddQuery(),
                $mainParams
            );
            if (count($rowsMainAdd) !== 1) {
                throw new CouldNotSaveException('Main add query must return 1 row');
            }
            $rawAuthorId = $rowsMainAdd[0]['identifier'] ?? null;
            if ($rawAuthorId === null) {
                throw new CouldNotSaveException('Main add query does not return identifier');
            }

            foreach ($translates as $translate) {
                $this->database->transactionQueryParams(
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
                throw new CouldNotSaveException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new CouldNotSaveException($e2->getMessage());
            }
        } catch (QueryException $e) {
            try {
                $this->database->transactionRollback();
                throw new CouldNotSaveException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new CouldNotSaveException($e2->getMessage());
            }
        }
        return $this->getById(new AuthorId($rawAuthorId));
    }

    /** @param array<string,string> $row */
    protected function createFromRow(array $row): Author
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Author id is ivalid');
        }

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Author name is ivalid');
        }

        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Author active is ivalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        // languages
        $rawLanguages = $row['languages'] ?? null;
        if ($rawLanguages === null) {
            throw new RepositoryException('Author languages param is ivalid');
        }
        $languages = $this->prepareRawLanguages($rawLanguages);

        // articles
        $rawArticles = $row['articles'] ?? null;
        if ($rawArticles === null) {
            throw new RepositoryException('Author articles param is ivalid');
        }
        $articles = $this->prepareRawArticles($rawArticles);

        // images
        $rawImages = $row['images'] ?? null;
        if ($rawImages === null) {
            throw new RepositoryException('Author images param is ivalid');
        }
        $images = $this->prepareRawImages($rawImages);

        // translates
        $translates = $this->createTranslates($rawIdentifier);

        // create a model
        return Author::load(
            new AuthorId($rawIdentifier),
            new Name($rawName),
            $active,
            $articles,
            $images,
            $languages,
            $translates
        );
    }

    /** @return array<int,Translate> */
    protected function createTranslates(string $authorId): array
    {
        $translates = [];

        $params = [$authorId];
        $query  = $this->translatesQuery();

        $rows = $this->database->queryParams($query, $params);

        foreach ($rows as $row) {
            $rawLanguage = $row['language'] ?? null;
            if ($rawLanguage === null) {
                throw new RepositoryException('Author translates language param is ivalid');
            }
            $rawDescription = $row['description'] ?? null;
            if ($rawDescription === null) {
                throw new RepositoryException('Author translates description param is ivalid');
            }
            $translates[] = new Translate(
                new LanguageId($rawLanguage),
                new Description($rawDescription)
            );
        }

        return $translates;
    }

    /**
     * @param string $rawImages - Json encoded array of strings
     * @return array<int,ImageId>
     */
    protected function prepareRawImages(string $rawImages): array
    {
        $decodedImages = json_decode($rawImages);

        $data = [];
        foreach ($decodedImages as $image) {
            $data[] = new ImageId($image);
        }
        return $data;
    }

        /**
         * @param string $rawArticles - Json encoded array of strings
         * @return array<int,ArticleId>
         */
    protected function prepareRawArticles(string $rawArticles): array
    {
        $decodedArticles = json_decode($rawArticles);

        $data = [];
        foreach ($decodedArticles as $article) {
            $data[] = new ArticleId($article);
        }
        return $data;
    }

    /**
     * @param string $rawLanguages - Json encoded array of strings
     * @return array<int,LanguageId>
     */
    protected function prepareRawLanguages(string $rawLanguages): array
    {
        $decodedLanguages = json_decode($rawLanguages);

        $data = [];
        foreach ($decodedLanguages as $language) {
            $data[] = new LanguageId($language);
        }
        return $data;
    }

    protected function defaultSelectQuery(): string
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

    protected function translatesQuery(): string
    {
        return <<<'QUERY'
        SELECT author_translates.language,
            author_translates.description
        FROM author_translates
        WHERE author_translates.author_id = $1
        QUERY;
    }

    protected function mainSaveQuery(): string
    {
        return <<<'QUERY'
        UPDATE author 
        SET name = $1, active = $2
        WHERE identifier = $3
        QUERY;
    }

    protected function translatesSaveQueryDelete(): string
    {
        return <<<'QUERY'
        DELETE FROM author_translates 
        WHERE author_id = $1
        QUERY;
    }

    protected function translatesSaveQueryInsert(): string
    {
        return <<<'QUERY'
        INSERT INTO author_translates (author_id, language, description)
            VALUES ($1, $2, $3)
        QUERY;
    }

    protected function mainAddQuery(): string
    {
        return <<<'QUERY'
        INSERT INTO author (name, active)
        VALUES ($1, $2)
        RETURNING identifier;
        QUERY;
    }

    protected function mainDeleteQuery(): string
    {
        return <<<'QUERY'
        DELETE FROM author 
        WHERE identifier = $1
        QUERY;
    }
}
