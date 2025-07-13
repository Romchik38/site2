<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\MostVisited;

use DateTime;
use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Article\MostVisited\Commands\List\SearchCriteria;
use Romchik38\Site2\Application\Article\MostVisited\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\MostVisited\RepositoryInterface;
use Romchik38\Site2\Application\Article\MostVisited\Views\ArticleDTO;
use Romchik38\Site2\Application\Article\MostVisited\Views\ImageDTO;
use Romchik38\Site2\Domain\Article\VO\Description as ArticleDescription;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Name as ArticleName;
use Romchik38\Site2\Domain\Article\VO\Views;
use Romchik38\Site2\Domain\Image\VO\Description as ImageDescription;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private DatabaseSqlInterface $database
    ) {
    }

    public function list(SearchCriteria $searchCriteria): array
    {
        $query  = $this->defaultQuery();
        $params = [
            ($searchCriteria->language)(),
            ($searchCriteria->count)(),
        ];

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
    private function createFromRow(array $row): ArticleDTO
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Article id is invalid');
        }
        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Article name is invalid');
        }
        $rawDescription = $row['description'] ?? null;
        if ($rawDescription === null) {
            throw new RepositoryException('Article description is invalid');
        }
        $rawCreatedAt = $row['created_at'] ?? null;
        if ($rawCreatedAt === null) {
            throw new RepositoryException('Article created at is invalid');
        }
        $rawViews = $row['views'] ?? null;
        if ($rawViews === null) {
            throw new RepositoryException('Article views is invalid');
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
            $articleDescription = new ArticleDescription($rawDescription);
            $views              = Views::fromString($rawViews);
            $imageId            = ImageId::fromString($rawImgId);
            $imageDescription   = new ImageDescription($rawImgDescription);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new ArticleDTO(
            $articleId,
            $articleName,
            $articleDescription,
            new DateTime($rawCreatedAt),
            $views,
            new ImageDTO($imageId, $imageDescription)
        );
    }

    private function defaultQuery(): string
    {
        return <<<'QUERY'
        SELECT article.identifier,
            article.created_at,
            article.views,
            article_translates.name,
            article_translates.description,
            img_translates.img_id,
            img_translates.description as img_description
        FROM
            article,
            article_translates,
            img,
            img_translates
        WHERE 
            article.identifier = article_translates.article_id
            AND article.active = 'true'
            AND article_translates.language = $1
            AND article.img_id = img.identifier
            AND img_translates.img_id = article.img_id
            AND img_translates.language = $1
        ORDER BY article.views DESC LIMIT $2
        QUERY;
    }
}
