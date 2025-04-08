<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Image;

use InvalidArgumentException;
use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Server\Models\Sql\DatabaseTransactionException;
use Romchik38\Site2\Domain\Image\Image;
use Romchik38\Site2\Domain\Image\ImageRepositoryInterface;
use Romchik38\Site2\Domain\Image\RepositoryException;
use Romchik38\Site2\Domain\Image\NoSuchImageException;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\Entities\Author;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Image\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Path;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Image\Entities\Article;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Image\Entities\Translate;
use Romchik38\Site2\Domain\Image\VO\Description;
use Romchik38\Site2\Domain\Image\NoSuchAuthorException;

final class Repository implements ImageRepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {  
    }

    public function getById(Id $id): Image
    {
        $query = $this->getByIdQuery();
        $params = [$id()];
        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $count = count($rows);
        if ($count === 0) {
            throw new NoSuchImageException(sprintf(
                'Image with id %s not exist',
                $id()
            ));
        }
        if ($count > 1) {
            throw new RepositoryException(sprintf(
                'Image with id %s has duplicates',
                $id()
            ));
        }

        $row = $rows[0];

        $model = $this->createModel($id, $row);
        return $model;
    }

    public function deleteById(Id $id): void
    {
        $query = $this->deleteByIdQuery();
        $params = [$id()];
        try {
            $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }

    public function findAuthor(AuthorId $id): Author
    {
        $query = $this->findAuthorQuery();
        $params = [$id()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $count = count($rows);
        if ($count === 0) {
            throw new NoSuchAuthorException(sprintf(
                'Image author with id %s not exist',
                $id()
            ));
        }
        if ($count > 1) {
            throw new RepositoryException(sprintf(
                'Image author with id %s has duplicates',
                $id()
            ));
        }

        $row = $rows[0];

        $authorEntity = $this->createAuthor($row);
        return $authorEntity;
    }

    public function save(Image $model): void
    {
        $imageName = $model->getName();
        $imageId = $model->getId();
        if ($model->isActive()) {
            $imageActive = 't';
        } else {
            $imageActive = 'f';
        }

        $authorId = $model->getAuthor()->id;

        $mainSaveQuery = $this->mainSaveQuery();
        $mainParams    = [$imageActive, $imageName(), $authorId(), $imageId()];

        $translates      = $model->getTranslates();

        try {
            $this->database->transactionStart();
            $this->database->transactionQueryParams(
                $mainSaveQuery,
                $mainParams
            );
            $this->database->transactionQueryParams(
                $this->translatesSaveQueryDelete(),
                [$imageId()]
            );
            foreach ($translates as $translate) {
                $this->database->transactionQueryParams(
                    $this->translatesSaveQueryInsert(),
                    [
                        $imageId(),
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
    }

    /** @todo test */
    public function add(Image $model): Image {
        $modelId = $model->getId();
        $imageName = $model->getName();
        $authorId = $model->getAuthor()->id;
        $path = $model->getPath();

        if ($model->isActive()) {
            $imageActive = 't';
        } else {
            $imageActive = 'f';
        }

        /** @todo test */
        if ($modelId === null) {
            $mainAddQuery = $this->mainAddQuery();
            $mainParams   = [$imageActive, $imageName(), $authorId(), $path()];
        } else {
            $mainAddQuery = $this->mainAddQueryWithId();
            $mainParams   = [$modelId, $imageActive, $imageName(), $authorId(), $path()];
        }
        
        $translates   = $model->getTranslates();

        try {
            $this->database->transactionStart();
            $rows = $this->database->transactionQueryParams(
                $mainAddQuery,
                $mainParams
            );
            if (count($rows) !== 1) {
                throw new RepositoryException('Result must return 1 row with id while adding new image');
            }
            $row = $rows[0];
            $rawImageId =  $row['identifier'] ?? null;
            if ($rawImageId === null) {
                throw new RepositoryException('Param id is invalid while adding new image');
            }
            $imageId = Id::fromString($rawImageId);
            foreach ($translates as $translate) {
                $this->database->transactionQueryParams(
                    $this->translatesSaveQueryInsert(),
                    [
                        $imageId(),
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

        return $this->getById($imageId);
    }

    /**
     * @param array<string,string> $row 
     * @throws InvalidArgumentException
     * @throws RepositoryException
     * */
    private function createModel(Id $id, array $row): Image
    {
        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Image active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Image name is invalid');
        }

        $rawPath = $row['path'] ?? null;
        if ($rawPath === null) {
            throw new RepositoryException('Image path is invalid');
        }

        $author = $this->createAuthor($row);

        $rawLanguages = $row['languages'] ?? null;
        if ($rawLanguages === null) {
            throw new RepositoryException('Image languages param is invalid');
        }
        $languages = $this->createLanguages($rawLanguages);
        
        $articles = $this->createArticles($id);

        $translates = $this->createTranslates($id);

        return Image::load(
            $id,
            $active,
            new Name($rawName),
            $author,
            new Path($rawPath),
            $languages,
            $articles,
            $translates
        );
    }

    /**
     * @throws RepositoryException
     * @return array<int,Translate> 
     * */
    private function createTranslates(Id $id): array
    {
        $query  = $this->translatesQuery();
        $params = [$id()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $translates = [];
        foreach ($rows as $row) {
            $rawDescription = $row['description'] ?? null;
            if ($rawDescription === null) {
                throw new RepositoryException('Image translate description is invalid');
            }
            $rawLanguage = $row['language'] ?? null;
            if ($rawLanguage === null) {
                throw new RepositoryException('Image translate language is invalid');
            }
            $translates[] = new Translate(
                new LanguageId($rawLanguage),
                new Description($rawDescription)
            );
        }
        return $translates;
    }
    
    /** 
     * @throws RepositoryException
     * @return array<int,Article>
     */
    protected function createArticles(Id $id): array
    {
        $query  = $this->articlesQuery();
        $params = [$id()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $articles = [];
        foreach ($rows as $row) {
            $rawIdentifier = $row['identifier'] ?? null;
            if ($rawIdentifier === null) {
                throw new RepositoryException('Image article identifier is invalid');
            }
            $rawActive = $row['active'] ?? null;
            if ($rawActive === null) {
                throw new RepositoryException('Image article active is invalid');
            }
            if ($rawActive === 't') {
                $active = true;
            } else {
                $active = false;
            }
            $articles[] = new Article(
                new ArticleId($rawIdentifier),
                $active
            );
        }
        return $articles;
    }

    /**
     * @param string $rawLanguages - Json encoded array of strings
     * @return array<int,LanguageId>
     */
    protected function createLanguages(string $rawLanguages): array
    {
        $decodedLanguages = json_decode($rawLanguages);

        $data = [];
        foreach ($decodedLanguages as $language) {
            $data[] = new LanguageId($language);
        }
        return $data;
    }

    /** 
     * @param array<string,string> $row
     * @throws RepositoryException
     * */
    private function createAuthor(array $row): Author
    {
        $rawId = $row['author_id'] ?? null;
        if ($rawId === null) {
            throw new RepositoryException('Image author id is invalid');
        }
        
        $rawActive = $row['author_active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Image author active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        return new Author(new AuthorId($rawId), $active);
    }

    private function getByIdQuery(): string
    {
        return <<<'QUERY'
            SELECT img.active,
                img.name,
                img.author_id,
                img.path,
                author.active as author_active,
                array_to_json (
                    array (SELECT language.identifier 
                        FROM language
                    ) 
                ) as languages
            FROM img,
                author
            WHERE img.identifier = $1
                AND img.author_id = author.identifier
        QUERY;
    }

    private function articlesQuery(): string
    {
        return <<<'QUERY'
            SELECT article.identifier,
                article.active
            FROM article
            WHERE article.img_id = $1
        QUERY;
    }

    private function translatesQuery(): string
    {
        return <<<'QUERY'
            SELECT img_translates.language,
                img_translates.description
            FROM img_translates
            WHERE img_translates.img_id = $1
        QUERY;
    }

    private function findAuthorQuery(): string
    {
        return <<<'QUERY'
            SELECT author.identifier as author_id,
                author.active
            FROM author
            WHERE author.identifier = $1
        QUERY;
    }

    private function mainSaveQuery(): string
    {
        return <<<'QUERY'
            UPDATE img
            SET active = $1,
                name = $2,
                author_id = $3
            WHERE img.identifier = $4
        QUERY;
    }

    protected function translatesSaveQueryDelete(): string
    {
        return <<<'QUERY'
        DELETE FROM img_translates 
        WHERE img_id = $1
        QUERY;
    }

    protected function translatesSaveQueryInsert(): string
    {
        return <<<'QUERY'
        INSERT INTO img_translates (img_id, language, description)
            VALUES ($1, $2, $3)
        QUERY;
    }

    private function mainAddQuery(): string
    {
        return <<<'QUERY'
            INSERT INTO img (active, name, author_id, path)
                VALUES ($1, $2, $3, $4)
                RETURNING identifier
        QUERY;
    }

    private function mainAddQueryWithId(): string
    {
        return <<<'QUERY'
            INSERT INTO img (identifier, active, name, author_id, path)
                VALUES ($1, $2, $3, $4, $5)
                RETURNING identifier
        QUERY;
    }

    private function deleteByIdQuery(): string
    {
        return <<<'QUERY'
            DELETE FROM img WHERE identifier = $1
        QUERY;
    }
}