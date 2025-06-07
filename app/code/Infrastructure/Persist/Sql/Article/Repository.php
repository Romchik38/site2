<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Article;

use DateTime;
use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Article\ArticleService\Exceptions\NoSuchArticleException;
use Romchik38\Site2\Application\Article\ArticleService\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\ArticleService\RepositoryInterface;
use Romchik38\Site2\Domain\Article\Article;
use Romchik38\Site2\Domain\Article\Entities\Audio;
use Romchik38\Site2\Domain\Article\Entities\Author;
use Romchik38\Site2\Domain\Article\Entities\Category;
use Romchik38\Site2\Domain\Article\Entities\Image;
use Romchik38\Site2\Domain\Article\Entities\Translate;
use Romchik38\Site2\Domain\Article\VO\Description as ArticleDescription;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Name as ArticleName;
use Romchik38\Site2\Domain\Article\VO\ShortDescription as ArticleShortDescription;
use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name as AuthorName;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function array_key_exists;
use function count;
use function json_decode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function getById(ArticleId $id): Article
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

    /** @todo implement */
    public function delete(Article $model): void
    {
    }

    public function findAuthor(AuthorId $id): Author
    {
        $query = $this->getAuthorQuery();
        $param = [$id()];

        try {
            $rows = $this->database->queryParams($query, $param);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $count = count($rows);
        if ($count !== 1) {
            throw new RepositoryException(sprintf(
                'Article author find returns invalid row count %d',
                $count
            ));
        }

        return $this->createAuthor($rows[0]);
    }

    /** @todo implement */
    public function save(Article $model): void
    {
    }

    /** @todo implement */
    public function add(Article $model): ArticleId
    {
        return new ArticleId('asd');
    }

    /**
     * @param array<string,string|null> $row
     * @throws RepositoryException
     * */
    private function createFromRow(ArticleId $id, array $row): Article
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

        $rawLanguages = $row['languages'] ?? null;
        if ($rawLanguages === null) {
            throw new RepositoryException('Article languages param is invalid');
        }
        $languages = $this->createLanguages($rawLanguages);

        // Author
        $author = $this->createAuthor($row);
        // Audio
        $audio = null;
        if (! array_key_exists('audio_id', $row)) {
            throw new RepositoryException('Article audio id is invalid');
        }
        $rawAudioId = $row['audio_id'];
        if ($rawAudioId !== null) {
            try {
                $audioId = AudioId::fromString($rawAudioId);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
            $audio = $this->createAudio($audioId);
        }
        // Image
        $image = null;
        if (! array_key_exists('img_id', $row)) {
            throw new RepositoryException('Article image id is invalid');
        }
        $rawImageId = $row['img_id'];
        if ($rawImageId !== null) {
            try {
                $imageId = ImageId::fromString($rawImageId);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
            $image = $this->createImage($imageId);
        }
        // Categories
        $categories = $this->createCategories($id);
        // Translates
        $translates = $this->createTranslates($id);

        // Article
        return new Article(
            $id,
            $active,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );
    }

    /**
     * @throws RepositoryException
     * */
    public function createAudio(AudioId $id): Audio
    {
        $query  = $this->getAudioQuery();
        $params = [$id()];
        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
        if (count($rows) !== 1) {
            throw new RepositoryException('Article audio data is invalid');
        }
        $firstRow  = $rows[0];
        $rawActive = $firstRow['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Article audio active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        return new Audio($id, $active);
    }

    /**
     * @param array<string,string|null> $row
     * @throws RepositoryException
     * */
    private function createAuthor(array $row): Author
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

        return new Author($id, $active, $name);
    }

    /**
     * @throws RepositoryException
     * @return array<int,Category>
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

            $rawCount = $row['article_count'] ?? null;
            if ($rawCount === null) {
                throw new RepositoryException('Article category count is invalid');
            }

            try {
                $id = new CategoryId($rawId);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }

            $categories[] = new Category($id, $active, (int) $rawCount);
        }

        return $categories;
    }

    /**  @throws RepositoryException */
    public function createImage(ImageId $imageId): Image
    {
        $query  = $this->getImageQuery();
        $params = [$imageId()];
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

        return new Image($imageId, $active);
    }

    /**
     * @param string $rawLanguages - Json encoded array of strings
     * @return array<int,LanguageId>
     */
    private function createLanguages(string $rawLanguages): array
    {
        $decodedLanguages = json_decode($rawLanguages);

        $data = [];
        foreach ($decodedLanguages as $language) {
            $data[] = new LanguageId($language);
        }
        return $data;
    }

    /**
     * @throws RepositoryException
     * @return array<int,Translate>
     */
    private function createTranslates(ArticleId $articleId): array
    {
        $translates = [];

        $query  = $this->getTranslatesQuery();
        $params = [$articleId()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        foreach ($rows as $row) {
            $rawLanguage = $row['language'] ?? null;
            if ($rawLanguage === null) {
                throw new RepositoryException('Article language is invalid');
            }
            $rawName = $row['name'] ?? null;
            if ($rawName === null) {
                throw new RepositoryException('Article name is invalid');
            }
            $rawShortDescription = $row['short_description'] ?? null;
            if ($rawShortDescription === null) {
                throw new RepositoryException('Article short description is invalid');
            }
            $rawDescription = $row['description'] ?? null;
            if ($rawDescription === null) {
                throw new RepositoryException('Article description is invalid');
            }
            $rawCreatedAt = $row['created_at'] ?? null;
            if ($rawCreatedAt === null) {
                throw new RepositoryException('Article created at is invalid');
            }
            $rawUpdatedAt = $row['updated_at'] ?? null;
            if ($rawUpdatedAt === null) {
                throw new RepositoryException('Article updated at is invalid');
            }

            try {
                $languageId       = new LanguageId($rawLanguage);
                $name             = new ArticleName($rawName);
                $shortDescription = new ArticleShortDescription($rawShortDescription);
                $description      = new ArticleDescription($rawDescription);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
            $translates[] = new Translate(
                $languageId,
                $name,
                $shortDescription,
                $description,
                new DateTime($rawCreatedAt),
                new DateTime($rawUpdatedAt)
            );
        }

        return $translates;
    }

    private function getByIdQuery(): string
    {
        return <<<'QUERY'
            SELECT article.active,
                article.author_id,
                article.img_id,
                article.audio_id,
                author.name as author_name,
                author.active as author_active,
                array_to_json (
                    array (SELECT language.identifier 
                        FROM language
                    ) 
                ) as languages
            FROM article,
                author
            WHERE article.identifier = $1
                AND article.author_id = author.identifier
        QUERY;
    }

    private function getAudioQuery(): string
    {
        return <<<'QUERY'
            SELECT audio.active
            FROM audio
            WHERE audio.identifier = $1
        QUERY;
    }

    private function getAuthorQuery(): string
    {
        return <<<'QUERY'
            SELECT author.identifier as author_id,
                author.name as author_name,
                author.active as author_active
            FROM author
            WHERE author.identifier = $1
        QUERY;
    }

    private function getImageQuery(): string
    {
        return 'SELECT img.active FROM img WHERE img.identifier = $1';
    }

    private function getCategoriesQuery(): string
    {
        return <<<'QUERY'
            SELECT category.identifier,
                category.active,
                (
                    SELECT count(article_id) 
                    FROM article_category
                    WHERE article_category.category_id = category.identifier
                ) as article_count
            FROM category,
                article_category
            WHERE article_category.article_id = $1
                AND article_category.category_id = category.identifier
        QUERY;
    }

    private function getTranslatesQuery(): string
    {
        return <<<'QUERY'
            SELECT article_translates.language,
                article_translates.name,
                article_translates.short_description,
                article_translates.description,
                article_translates.created_at,
                article_translates.updated_at
            FROM article_translates
            WHERE article_translates.article_id = $1
        QUERY;
    }
}
