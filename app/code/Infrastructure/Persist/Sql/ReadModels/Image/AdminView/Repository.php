<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Image\AdminView;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Image\AdminView\RepositoryException;
use Romchik38\Site2\Application\Image\AdminView\RepositoryInterface;
use Romchik38\Site2\Application\Image\AdminView\View\ArticleDto;
use Romchik38\Site2\Application\Image\AdminView\View\AuthorDto;
use Romchik38\Site2\Application\Image\AdminView\View\BannerDto;
use Romchik38\Site2\Application\Image\AdminView\View\Dto;
use Romchik38\Site2\Application\Image\AdminView\View\TranslateDto;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name as AuthorName;
use Romchik38\Site2\Domain\Banner\VO\Identifier as BannerId;
use Romchik38\Site2\Domain\Banner\VO\Name as BannerName;
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

    public function listAuthors(): array
    {
        return $this->createAuthors();
    }

    /**
     * @throws RepositoryException
     * @param array<string,string|null> $row
     * */
    private function createFromRow(array $row): Dto
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Image id is invalid');
        }

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
            throw new RepositoryException('Image author name is invalid');
        }

        // Author
        $rawAuthorId = $row['author_id'] ?? null;
        if ($rawAuthorId === null) {
            throw new RepositoryException('Image author id is invalid');
        }

        $rawAuthorName = $row['author_name'] ?? null;
        if ($rawAuthorName === null) {
            throw new RepositoryException('Image author name is invalid');
        }

        $rawAuthorActive = $row['author_active'] ?? null;
        if ($rawAuthorActive === null) {
            throw new RepositoryException('Image author active is invalid');
        }
        if ($rawAuthorActive === 't') {
            $activeAuthor = true;
        } else {
            $activeAuthor = false;
        }

        try {
            $authorId   = AuthorId::fromString($rawAuthorId);
            $authorName = new AuthorName($rawAuthorName);
            $imageId    = Id::fromString($rawIdentifier);
            $imageName  = new Name($rawName);
            $imagePath  = new Path($rawPath);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $author = new AuthorDto($authorId, $authorName, $activeAuthor);

        $translates = $this->createTranslates($rawIdentifier);
        $articles   = $this->createArticles($rawIdentifier);
        $authors    = $this->createAuthors();
        $banners    = $this->createBanners($rawIdentifier);

        return new Dto(
            $imageId,
            $active,
            $imageName,
            $imagePath,
            $author,
            $translates,
            $articles,
            $authors,
            $banners
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
                throw new RepositoryException('Image translate description is invalid');
            }
            $rawLanguage = $row['language'] ?? null;
            if ($rawLanguage === null) {
                throw new RepositoryException('Image translate language is invalid');
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
            $articles[] = new ArticleDto(
                new ArticleId($rawIdentifier),
                $active
            );
        }
        return $articles;
    }

    /**
     * @throws RepositoryException
     * @return array<int,AuthorDto>
     * */
    private function createAuthors(): array
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
                throw new RepositoryException('Image author identifier is invalid');
            }
            $rawName = $row['name'] ?? null;
            if ($rawName === null) {
                throw new RepositoryException('Image author name is invalid');
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
            $authors[] = new AuthorDto(
                AuthorId::fromString($rawIdentifier),
                new AuthorName($rawName),
                $active
            );
        }
        return $authors;
    }

    /** @return array<int,BannerDto> */
    private function createBanners(string $id): array
    {
        $query  = $this->bannersQuery();
        $params = [$id];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $banners = [];
        foreach ($rows as $row) {
            $rawIdentifier = $row['identifier'] ?? null;
            if ($rawIdentifier === null) {
                throw new RepositoryException('Image banner identifier is invalid');
            }
            $rawActive = $row['active'] ?? null;
            if ($rawActive === null) {
                throw new RepositoryException('Image banner active is invalid');
            }
            if ($rawActive === 't') {
                $active = true;
            } else {
                $active = false;
            }

            $rawName = $row['name'] ?? null;
            if ($rawName === null) {
                throw new RepositoryException('Image banner name is invalid');
            }

            try {
                $bannerId   = BannerId::fromString($rawIdentifier);
                $bannerName = new BannerName($rawName);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }

            $banners[] = new BannerDto($bannerId, $active, $bannerName);
        }
        return $banners;
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

    private function bannersQuery(): string
    {
        return <<<'QUERY'
            SELECT banner.identifier,
                banner.active,
                banner.name
            FROM banner
            WHERE banner.img_id = $1
        QUERY;
    }
}
