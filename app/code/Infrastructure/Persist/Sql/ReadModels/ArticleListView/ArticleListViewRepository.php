<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleListView;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Site2\Application\ArticleListView\View\ArticleListViewRepositoryInterface;
use Romchik38\Site2\Application\ArticleListView\View\SearchCriteriaInterface;

final class ArticleListViewRepository implements ArticleListViewRepositoryInterface
{

    public function __construct(
        protected DatabaseInterface $database
    ) {}

    public function list(SearchCriteriaInterface $searchCriteria): array
    {
        $expression = [];
        $params = [$searchCriteria->language()];
        $paramCount = 1;

        /** ORDER BY */
        $orderBy = $searchCriteria->orderBy();
        if (strlen($orderBy) > 0) {
            $expression[] = 'ORDER BY %s' . $orderBy;
        }

        /** LIMIT */
        $limit = $searchCriteria->limit();
        $expression[] = sprintf('LIMIT $%s', ++$paramCount);
        $params[] = $limit;

        /** OFFSET */
        $offset = $searchCriteria->offset();
        $expression[] = sprintf('OFFSET $%s', ++$paramCount);
        $params[] = $offset;

        $rows = $this->listRows(
            implode(' ', $expression),
            $params
        );

        return $rows;
    }

    /**
     * SELECT
     * used to select rows from all tables by given expression
     */
    protected function listRows(
        string $expression,
        array $params
    ): array {

        $query = <<<QUERY
        WITH categories AS
        (
            SELECT category_translates.category_id,
                category_translates.name
            FROM category_translates
            WHERE category_translates.language = $1
        )
        SELECT
        article.identifier,
        article.active,
        article_translates.language,
        article_translates.name,
        article_translates.description,
        article_translates.created_at,
        article_translates.updated_at,
        array_to_json (
            array (
                select
                    categories.name
                from
                    categories, article_category
                where
                    article.identifier = article_category.article_id AND
                    categories.category_id = article_category.category_id
            )
        ) as category
        FROM
            article,
            article_translates
        WHERE
            article.identifier = article_translates.article_id
            AND article.active = 'true'
            AND article_translates.language = $1
        QUERY;

        $query = sprintf('%s %s', $query, $expression);

        $rows = $this->database->queryParams($query, $params);

        return $rows;
    }
}
