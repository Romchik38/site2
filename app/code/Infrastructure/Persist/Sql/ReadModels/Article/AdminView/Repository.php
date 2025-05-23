<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\AdminView;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Article\AdminView\Dto\ArticleDto;
use Romchik38\Site2\Application\Article\AdminView\Dto\AudioDto;
use Romchik38\Site2\Application\Article\AdminView\Dto\AudioTranslateDto;
use Romchik38\Site2\Application\Article\AdminView\Dto\AuthorDto;
use Romchik38\Site2\Application\Article\AdminView\Dto\CategoryDto;
use Romchik38\Site2\Application\Article\AdminView\Dto\ImageDto;
use Romchik38\Site2\Application\Article\AdminView\NoSuchArticleException;
use Romchik38\Site2\Application\Article\AdminView\RepositoryException;
use Romchik38\Site2\Application\Article\AdminView\RepositoryInterface;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Audio\VO\Description as AudioDescription;
use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;
use Romchik38\Site2\Domain\Audio\VO\Name as AudioName;
use Romchik38\Site2\Domain\Audio\VO\Path as AudioPath;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name as AuthorName;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Image\VO\Name as ImageName;
use Romchik38\Site2\Domain\Image\VO\Path as ImagePath;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function array_key_exists;
use function count;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function getById(ArticleId $id): ArticleDto
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
            throw new NoSuchArticleException(sprintf(
                'Article with id %s not exist',
                (string) $id
            ));
        }
        if ($count > 1) {
            throw new RepositoryException(sprintf(
                'Article with id %s has duplicates',
                (string) $id
            ));
        }

        $rawArticle = $rows[0];

        return $this->createFromRow($id, $rawArticle);
    }

    /**
     * @param array<string,string|null> $row
     * @throws RepositoryException
     * */
    private function createFromRow(ArticleId $id, array $row): ArticleDto
    {
        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Audio active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        // Author
        $author = $this->createAuthor($row);
        // Audio
        $audio = $this->createAudio($row);
        // Image
        $image = $this->createImage($row);
        // Categories
        $categories = $this->createCategories($id);
        // Translates
        $translates = $this->createTranslates($id);
        // Article
        return new ArticleDto(
            $id,
            $active,
            $audio,
            $author,
            $image,
            $categories,
            $translates
        );
    }

    /**
     * @throws RepositoryException
     * @return array<int,CategoryDto>
     */
    private function createCategories(ArticleId $articleId): array
    {
        $categories = [];

        $query  = $this->getCategoriesQuery();
        $params = [$articleId()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        foreach ($rows as $row) {
            $rawId = $row['identifier'] ?? null;
            if ($rawId === null) {
                throw new RepositoryException('Article category id is invalid');
            }

            $rawActive = $row['active'] ?? null;
            if ($rawActive === null) {
                throw new RepositoryException('Article category active is invalid');
            }
            if ($rawActive === 't') {
                $active = true;
            } else {
                $active = false;
            }

            try {
                $id = new CategoryId($rawId);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }

            $categories[] = new CategoryDto($id, $active);
        }

        return $categories;
    }

    /**
     * @param array<string,string|null> $row
     * @throws RepositoryException
     * */
    private function createAuthor(array $row): AuthorDto
    {
        $rawId = $row['author_id'] ?? null;
        if ($rawId === null) {
            throw new RepositoryException('Article author id is invalid');
        }

        $rawActive = $row['author_active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Article author active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawName = $row['author_name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Article author name is invalid');
        }

        try {
            $id   = new AuthorId($rawId);
            $name = new AuthorName($rawName);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new AuthorDto($id, $active, $name);
    }

    /**
     * @param array<string,string|null> $articleRow
     * @throws RepositoryException
     * */
    private function createAudio(array $articleRow): ?AudioDto
    {
        $audio = null;
        if (! array_key_exists('audio_id', $articleRow)) {
            throw new RepositoryException('Article audio id is invalid');
        } else {
            $rawId = $articleRow['audio_id'];
            if ($rawId === null) {
                return $audio;
            }

            $query  = $this->getAudioQuery();
            $params = [$rawId];

            try {
                $rows = $this->database->queryParams($query, $params);
            } catch (QueryException $e) {
                throw new RepositoryException($e->getMessage());
            }

            if (count($rows) === 0) {
                throw new RepositoryException('Article audio data is invalid');
            }

            $firstRow = $rows[0];

            $rawActive = $firstRow['active'] ?? null;
            if ($rawActive === null) {
                throw new RepositoryException('Article audio active is invalid');
            }
            if ($rawActive === 't') {
                $active = true;
            } else {
                $active = false;
            }

            $rawName = $firstRow['name'] ?? null;
            if ($rawName === null) {
                throw new RepositoryException('Article audio name is invalid');
            }

            $translates = [];
            foreach ($rows as $row) {
                $translates[] = $this->createAudioTranslates($row);
            }

            try {
                $id   = AudioId::fromString($rawId);
                $name = new AudioName($rawName);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }

            return new AudioDto($id, $active, $name, $translates);
        }
    }

    /**
     * @param array<string,string|null> $row
     * @throws RepositoryException
     * */
    private function createAudioTranslates(array $row): AudioTranslateDto
    {
        $rawLanguage = $row['language'] ?? null;
        if ($rawLanguage === null) {
            throw new RepositoryException('Article audio translate language is invalid');
        }

        $rawDescription = $row['description'] ?? null;
        if ($rawDescription === null) {
            throw new RepositoryException('Article audio translate description is invalid');
        }

        $rawPath = $row['path'] ?? null;
        if ($rawPath === null) {
            throw new RepositoryException('Article audio translate path is invalid');
        }

        $rawLanguage;
        $rawDescription;
        $rawPath;

        try {
            $language    = new LanguageId($rawLanguage);
            $description = new AudioDescription($rawDescription);
            $path        = new AudioPath($rawPath);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new AudioTranslateDto($language, $description, $path);
    }

    /**
     * @param array<string,string|null> $row
     * @throws RepositoryException
     * */
    private function createImage(array $articleRow): ?ImageDto
    {
        if (! array_key_exists('img_id', $articleRow)) {
            throw new RepositoryException('Article image id is invalid');
        }
        $rawId = $articleRow['img_id'];
        if ($rawId === null) {
            return null;
        }

        $query  = $this->getImageQuery();
        $params = [$rawId];
        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
        if (count($rows) !== 1) {
            throw new RepositoryException('Article image data is invalid');
        }
        $firstRow  = $rows[0];
        $rawActive = $firstRow['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Article image active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }
        $rawName = $firstRow['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Article image name is invalid');
        }
        $rawPath = $firstRow['path'] ?? null;
        if ($rawPath === null) {
            throw new RepositoryException('Article image path is invalid');
        }
        try {
            $id   = ImageId::fromString($rawId);
            $name = new ImageName($rawName);
            $path = new ImagePath($rawPath);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }
        return new ImageDto($id, $active, $name, $path);
    }

    private function getByIdQuery(): string
    {
        return <<<'QUERY'
            SELECT article.active,
                article.author_id,
                article.img_id,
                article.audio_id,
                author.name as author_name,
                author.active as author_active
            FROM article,
                author
            WHERE article.identifier = $1
                AND article.author_id = author.identifier
        QUERY;
    }

    private function getAudioQuery(): string
    {
        return <<<'QUERY'
            SELECT audio.active,
                audio.name
                audio_translates.language,
                audio_translates.description,
                audio_translates.path
            FROM audio,
                audio_translates
            WHERE audio.identifier = $1
                AND audio.identifier = audio_translates.audio_id
        QUERY;
    }

    private function getImageQuery(): string
    {
        return <<<'QUERY'
            SELECT img.active,
                img.name,
                img.path
            FROM img
            WHERE img.identifier = $1
        QUERY;
    }

    private function getCategoriesQuery(): string
    {
        return <<<'QUERY'
            SELECT category.identifier,
                category.active
            FROM category,
                article_category
            WHERE article_category.article_id = $1
                AND article_category.category_id = category.identifier
        QUERY;
    }
}
