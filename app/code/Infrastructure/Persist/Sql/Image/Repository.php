<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Image;

use InvalidArgumentException;
use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
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
        
        $rawActive = $row['active'] ?? null;
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
}