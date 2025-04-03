<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Image\AdminView;

use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Site2\Application\Image\AdminView\RepositoryException;
use Romchik38\Site2\Application\Image\AdminView\RepositoryInterface;
use Romchik38\Site2\Application\Image\AdminView\View\ArticleDto;
use Romchik38\Site2\Application\Image\AdminView\View\AuthorDto;
use Romchik38\Site2\Application\Image\AdminView\View\Dto;
use Romchik38\Site2\Application\Image\AdminView\View\TranslateDto;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name as AuthorName;
use Romchik38\Site2\Domain\Image\NoSuchImageException;
use Romchik38\Site2\Domain\Image\VO\Description;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Path;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function count;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function getById(Id $id): Dto
    {
        $query  = $this->getByIdQuery();
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
                (string) $id
            ));
        }
        if ($count > 1) {
            throw new RepositoryException(sprintf(
                'Image with id %s has duplicates',
                (string) $id
            ));
        }

        $rawImage = $rows[0];

        return $this->createFromRow($rawImage);
    }

    /** @param array<string,string> $row */
    private function createFromRow(array $row): Dto
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Image id is ivalid');
        }

        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Image active is ivalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Image name is ivalid');
        }

        $rawPath = $row['path'] ?? null;
        if ($rawPath === null) {
            throw new RepositoryException('Image author name is ivalid');
        }

        // Author
        $rawAuthorId = $row['author_id'] ?? null;
        if ($rawAuthorId === null) {
            throw new RepositoryException('Image author id is ivalid');
        }

        $rawAuthorName = $row['author_name'] ?? null;
        if ($rawAuthorName === null) {
            throw new RepositoryException('Image author name is ivalid');
        }

        $rawAuthorActive = $row['active'] ?? null;
        if ($rawAuthorActive === null) {
            throw new RepositoryException('Image author active is ivalid');
        }
        if ($rawAuthorActive === 't') {
            $activeAuthor = true;
        } else {
            $activeAuthor = false;
        }

        $author = new AuthorDto(
            new AuthorId($rawAuthorId),
            new AuthorName($rawAuthorName),
            $activeAuthor
        );

        $translates = $this->createTranslates($rawIdentifier);
        $articles   = $this->createArticles($rawIdentifier);
        $authors    = $this->createAuthors($rawIdentifier);

        return new Dto(
            new Id((int) $rawIdentifier),
            $active,
            new Name($rawName),
            new Path($rawPath),
            $author,
            $translates,
            $articles,
            $authors
        );
    }

    /** @return array<int,TranslateDto> */
    private function createTranslates(string $id): array
    {
        $query  = $this->translatesQuery();
        $params = [$id];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $translates = [];
        foreach ($rows as $row) {
            $rawDescription = $row['description'] ?? null;
            if ($rawDescription === null) {
                throw new RepositoryException('Image translate description is ivalid');
            }
            $rawLanguage = $row['language'] ?? null;
            if ($rawLanguage === null) {
                throw new RepositoryException('Image translate language is ivalid');
            }
            $translates[] = new TranslateDto(
                new LanguageId($rawLanguage),
                new Description($rawDescription)
            );
        }
        return $translates;
    }

    /** @return array<int,ArticleDto> */
    private function createArticles(string $id): array
    {
        $query  = $this->articlesQuery();
        $params = [$id];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $articles = [];
        foreach ($rows as $row) {
            $rawIdentifier = $row['identifier'] ?? null;
            if ($rawIdentifier === null) {
                throw new RepositoryException('Image article identifier is ivalid');
            }
            $rawActive = $row['active'] ?? null;
            if ($rawActive === null) {
                throw new RepositoryException('Image article active is ivalid');
            }
            if ($rawActive === 't') {
                $active = true;
            } else {
                $active = false;
            }
            $articles[] = new ArticleDto(
                new ArticleId($rawIdentifier),
                $active
            );
        }
        return $articles;
    }

    /** @return array<int,AuthorDto> */
    private function createAuthors(string $id): array
    {
        $query = $this->authorsQuery();
        try {
            $rows = $this->database->queryParams($query, []);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
        $authors = [];
        foreach ($rows as $row) {
            $rawIdentifier = $row['identifier'] ?? null;
            if ($rawIdentifier === null) {
                throw new RepositoryException('Image author identifier is ivalid');
            }
            $rawName = $row['name'] ?? null;
            if ($rawName === null) {
                throw new RepositoryException('Image author name is ivalid');
            }
            $rawActive = $row['active'] ?? null;
            if ($rawActive === null) {
                throw new RepositoryException('Image author active is ivalid');
            }
            if ($rawActive === 't') {
                $active = true;
            } else {
                $active = false;
            }
            $authors[] = new AuthorDto(
                new AuthorId($rawIdentifier),
                new AuthorName($rawName),
                $active
            );
        }
        return $authors;
    }

    private function getByIdQuery(): string
    {
        return <<<'QUERY'
            SELECT img.identifier,
                img.active,
                img.name,
                img.author_id,
                img.path,
                author.name as author_name,
                author.active as author_active
            FROM img,
                author
            WHERE img.identifier = $1
                AND img.author_id = author.identifier
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

    private function articlesQuery(): string
    {
        return <<<'QUERY'
            SELECT article.identifier,
                article.active
            FROM article
            WHERE article.img_id = $1
        QUERY;
    }

    private function authorsQuery(): string
    {
        return <<<'QUERY'
            SELECT author.identifier,
                author.name,
                author.active
            FROM author
        QUERY;
    }
}
