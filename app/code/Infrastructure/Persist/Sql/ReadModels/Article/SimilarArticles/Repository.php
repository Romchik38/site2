<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\SimilarArticles;

use DateTime;
use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Article\SimilarArticles\Commands\ListSimilar\SearchCriteria;
use Romchik38\Site2\Application\Article\SimilarArticles\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\SimilarArticles\RepositoryInterface;
use Romchik38\Site2\Application\Article\SimilarArticles\View\ArticleDto;
use Romchik38\Site2\Application\Article\SimilarArticles\View\ImageDto;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Name as ArticleName;
use Romchik38\Site2\Domain\Article\VO\ShortDescription as ArticleShortDescription;
use Romchik38\Site2\Domain\Image\VO\Description as ImageDescription;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Image\VO\Path;

use function implode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private DatabaseSqlInterface $database
    ) {
    }

    public function list(SearchCriteria $searchCriteria): array
    {
        $params = [];
        // with
        $count    = 0;
        $pointers = [];
        foreach ($searchCriteria->categories as $category) {
            $count++;
            $pointers[] = '$' . $count;
            $params[]   = (string) $category;
        }
        $articleIdPoiner = '$' . ++$count;
        $params[]        = (string) $searchCriteria->articleId;
        $rowsQueryPart   = sprintf(
            $this->withQueryPart(),
            implode(',', $pointers),
            $articleIdPoiner
        );
        // default
        $languagePoiner   = '$' . ++$count;
        $countPoiner      = '$' . ++$count;
        $defaultQueryPart = sprintf($this->defaultQueryPart(), $languagePoiner, $countPoiner);
        $params[]         = (string) $searchCriteria->languageId;
        $params[]         = (string) $searchCriteria->count;

        // common
        $query = $rowsQueryPart . $defaultQueryPart;

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $models = [];

        foreach ($rows as $row) {
            $models[] = $this->createFromRow($row);
        }
        return $models;
    }

    /**
     * @throws RepositoryException
     * @param array<string,string|null> $row
     * */
    private function createFromRow(array $row): ArticleDto
    {
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
            throw new RepositoryException('Article short_description is invalid');
        }
        $rawCreatedAt = $row['created_at'] ?? null;
        if ($rawCreatedAt === null) {
            throw new RepositoryException('Article created at is invalid');
        }
        $rawImgId = $row['img_id'] ?? null;
        if ($rawImgId === null) {
            throw new RepositoryException('Article img id at is invalid');
        }
        $rawImgDescription = $row['img_description'] ?? null;
        if ($rawImgDescription === null) {
            throw new RepositoryException('Article img description at is invalid');
        }

        try {
            $articleId          = new ArticleId($rawIdentifier);
            $articleName        = new ArticleName($rawName);
            $articleDescription = new ArticleShortDescription($rawShortDescription);
            $imageId            = ImageId::fromString($rawImgId);
            $imageDescription   = new ImageDescription($rawImgDescription);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new ArticleDto(
            $articleId,
            $articleName,
            $articleDescription,
            new DateTime($rawCreatedAt),
            new ImageDto($imageId, $imageDescription)
        );
    }

    private function defaultQueryPart(): string
    {
        return <<<'QUERY'
        SELECT article.identifier,
            article.created_at,
            article_translates.name,
            article_translates.short_description,
            img_translates.img_id,
            img_translates.description as img_description
        FROM
            article,
            article_translates,
            img,
            img_translates,
            rows
        WHERE 
            article.identifier = article_translates.article_id
            AND article.active = 'true'
            AND article_translates.language = %s
            AND article.img_id = img.identifier
            AND img_translates.img_id = article.img_id
            AND img_translates.language = article_translates.language
            AND article.identifier = rows.identifier
            ORDER BY article.created_at DESC
            LIMIT %s
        QUERY;
    }

    public function withQueryPart(): string
    {
        return <<<'WITH_QUERY'
        WITH rows as 
        (
            SELECT distinct article.identifier 
            FROM article,
                article_category
            WHERE  article.identifier = article_category.article_id
                AND article_category.category_id IN (%s)
                AND article.identifier <> %s
        )
        WITH_QUERY;
    }
}
