<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\AdminMostVisited;

use DateTime;
use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Article\AdminMostVisited\Commands\List\SearchCriteria;
use Romchik38\Site2\Application\Article\AdminMostVisited\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\AdminMostVisited\RepositoryInterface;
use Romchik38\Site2\Application\Article\AdminMostVisited\Views\ArticleDTO;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Name as ArticleName;
use Romchik38\Site2\Domain\Article\VO\Views;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private DatabaseSqlInterface $database
    ) {
    }

    public function list(SearchCriteria $searchCriteria): array
    {
        $paramLanguage = ($searchCriteria->language)();
        $query         = $this->defaultQuery();
        $params        = [$paramLanguage];

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
        $rawCreatedAt = $row['created_at'] ?? null;
        if ($rawCreatedAt === null) {
            throw new RepositoryException('Article created at is invalid');
        }
        $rawViews = $row['views'] ?? null;
        if ($rawViews === null) {
            throw new RepositoryException('Article views is invalid');
        }

        try {
            $articleId   = new ArticleId($rawIdentifier);
            $articleName = new ArticleName($rawName);
            $views       = Views::fromString($rawViews);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new ArticleDTO(
            $articleId,
            $articleName,
            new DateTime($rawCreatedAt),
            $views
        );
    }

    private function defaultQuery(): string
    {
        return <<<'QUERY'
        SELECT article.identifier,
            article.created_at,
            article.views,
            article_translates.name
        FROM
            article,
            article_translates
        WHERE 
            article.identifier = article_translates.article_id
            AND article.active = 'true'
            AND article_translates.language = $1
        ORDER BY article.views DESC
        QUERY;
    }
}
