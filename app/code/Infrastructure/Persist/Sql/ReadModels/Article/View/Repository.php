<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\View;

use DateTime;
use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Article\View\Find;
use Romchik38\Site2\Application\Article\View\NoSuchArticleException;
use Romchik38\Site2\Application\Article\View\RepositoryException;
use Romchik38\Site2\Application\Article\View\RepositoryInterface;
use Romchik38\Site2\Application\Article\View\View\ArticleIdNameDTO;
use Romchik38\Site2\Application\Article\View\View\ArticleViewDTO;
use Romchik38\Site2\Application\Article\View\View\AudioDTOFactory;
use Romchik38\Site2\Application\Article\View\View\AuthorDTO;
use Romchik38\Site2\Application\Article\View\View\CategoryDTO;
use Romchik38\Site2\Application\Article\View\View\ImageDTOFactory;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Category\VO\Name as CategoryName;

use function count;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database,
        private readonly ImageDTOFactory $imageDtoFactory,
        private readonly AudioDTOFactory $audioDtoFactory
    ) {
    }

    public function getByIdAndLanguage(Find $command): ArticleViewDTO
    {
        $articleId = $command->id();
        $language  = $command->language();
        $params    = [$language, $articleId];

        try {
            $rows = $this->database->queryParams($this->getByIdQuery(), $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        if (count($rows) === 0) {
            throw new NoSuchArticleException(sprintf(
                'Article with id %s and language %s not found',
                $articleId,
                $language
            ));
        } elseif (count($rows) > 1) {
            throw new RepositoryException(sprintf(
                'Article with id %s and language %s has duplicate',
                $articleId,
                $language
            ));
        }

        $row = $rows[0];

        return $this->createFromRow($row, $articleId, $language);
    }

    /** @return array<int,string> */
    public function listIds(): array
    {
        $query = <<<'QUERY'
        SELECT article.identifier FROM article 
        WHERE article.active = 'true'
        QUERY;

        try {
            $rows = $this->database->queryParams($query, []);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $ids = [];
        foreach ($rows as $row) {
            $rawIdentifier = $row['identifier'] ?? null;
            if ($rawIdentifier === null) {
                throw new RepositoryException('Article id is invalid');
            }
            $ids[] = $rawIdentifier;
        }
        return $ids;
    }

    public function listIdName(string $language): array
    {
        $query = <<<'QUERY'
        SELECT article.identifier, article_translates.name 
        FROM article, article_translates
        WHERE article.active = 'true' 
            AND article.identifier = article_translates.article_id
            AND article_translates.language = $1
        QUERY;

        try {
            $rows = $this->database->queryParams($query, [$language]);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $dtos = [];
        foreach ($rows as $row) {
            $rawIdentifier = $row['identifier'] ?? null;
            if ($rawIdentifier === null) {
                throw new RepositoryException('Article id is invalid');
            }
            $rawName = $row['name'] ?? null;
            if ($rawName === null) {
                throw new RepositoryException('Article name is invalid');
            }
            $dtos[] = new ArticleIdNameDTO($rawIdentifier, $rawName);
        }
        return $dtos;
    }

    /**
     * @param array<string,string|null> $row
     * @throws RepositoryException
     * */
    private function createFromRow(
        array $row,
        string $articleId,
        string $language
    ): ArticleViewDTO {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Article id is invalid');
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
        $rawAuthorId = $row['author_id'] ?? null;
        if ($rawAuthorId === null) {
            throw new RepositoryException('Article author id at is invalid');
        }
        $rawAuthorDescription = $row['author_description'] ?? null;
        if ($rawAuthorDescription === null) {
            throw new RepositoryException('Article author description at is invalid');
        }
        $rawImgId = $row['img_id'] ?? null;
        if ($rawImgId === null) {
            throw new RepositoryException('Article img id at is invalid');
        }
        $rawImgPath = $row['img_path'] ?? null;
        if ($rawImgPath === null) {
            throw new RepositoryException('Article img path at is invalid');
        }
        $rawImgDescription = $row['img_description'] ?? null;
        if ($rawImgDescription === null) {
            throw new RepositoryException('Article img description at is invalid');
        }
        $rawImgAuthorDescription = $row['img_author_description'] ?? null;
        if ($rawImgAuthorDescription === null) {
            throw new RepositoryException('Article img author description at is invalid');
        }

        $rawAudioPath = $row['audio_path'] ?? null;
        if ($rawAudioPath === null) {
            throw new RepositoryException('Article audio path at is invalid');
        }
        $rawAudioDescription = $row['audio_description'] ?? null;
        if ($rawAudioDescription === null) {
            throw new RepositoryException('Article audio description at is invalid');
        }

        $categories = $this->createCategories($articleId, $language);

        return new ArticleViewDTO(
            $rawIdentifier,
            $rawName,
            $rawShortDescription,
            $rawDescription,
            $categories,
            new DateTime($rawCreatedAt),
            new AuthorDTO(
                $rawAuthorId,
                $rawAuthorDescription
            ),
            $this->imageDtoFactory->create(
                $rawImgId,
                $rawImgPath,
                $rawImgDescription,
                $rawImgAuthorDescription
            ),
            $this->audioDtoFactory->create(
                $rawAudioPath,
                $rawAudioDescription,
            )
        );
    }

    /**
     * @throws RepositoryException
     * @return array<int,CategoryDTO>
     */
    private function createCategories(string $articleId, string $language): array
    {
        $categories = [];

        $query  = $this->categoryQuery();
        $params = [$language, $articleId];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        foreach ($rows as $row) {
            $rawId = $row['category_id'] ?? null;
            if ($rawId === null) {
                throw new RepositoryException('Article category id is invalid');
            }
            $rawName = $row['name'] ?? null;
            if ($rawName === null) {
                throw new RepositoryException('Article category name is invalid');
            }

            try {
                $id           = new CategoryId($rawId);
                $name         = new CategoryName($rawName);
                $categories[] = new CategoryDTO($id, $name);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
        }

        return $categories;
    }

    private function getByIdQuery(): string
    {
        return <<<'QUERY'
        WITH img_authors AS
        (
            SELECT author_translates.author_id,
                author_translates.description
            FROM author_translates
            WHERE author_translates.language = $1
        )       
        SELECT article.identifier,
            article.created_at,
            article_translates.name,
            article_translates.short_description,
            article_translates.description,
            author_translates.author_id,
            author_translates.description as author_description,
            img.path as img_path,
            img_translates.img_id,
            img_translates.description as img_description,
            audio_translates.description as audio_description,
            audio_translates.path as audio_path,
            img_authors.description as img_author_description
        FROM
            article,
            article_translates,
            author_translates,
            img,
            img_translates,
            audio_translates,
            img_authors
        WHERE 
            article.identifier = $2
            AND article.identifier = article_translates.article_id
            AND article.active = 'true'
            AND article_translates.language = $1
            AND author_translates.author_id = article.author_id
            AND author_translates.language = $1
            AND article.img_id = img.identifier
            AND img_translates.img_id = article.img_id
            AND img_translates.language = $1
            AND audio_translates.audio_id = article.audio_id
            AND audio_translates.language = $1
            AND img_authors.author_id = img.author_id
        QUERY;
    }

    private function categoryQuery(): string
    {
        return <<<'QUERY'
        SELECT category_translates.category_id,
            category_translates.name
        FROM category_translates,
            article_category
        WHERE category_translates.language = $1 AND
            article_category.category_id = category_translates.category_id AND
            article_category.article_id = $2
        QUERY;
    }
}
