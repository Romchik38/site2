<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleListView;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaInterface;
use Romchik38\Site2\Application\ArticleListView\View\ArticleListViewRepositoryInterface;

final class ArticleListViewRepository implements ArticleListViewRepositoryInterface
{

    public function __construct(
        protected DatabaseInterface $database
    ) {}
    
    public function list(SearchCriteriaInterface $searchCriteria): array {
        
    }

    /**
     * SELECT
     * used to select rows from all tables by given expression
     */
    protected function listRows(
        array $selectedFields,
        array $selectedTables,
        string $expression,
        array $params
    ): array {

        $query = 'SELECT ' . implode(', ', $selectedFields)
            . ' FROM ' . implode(', ', $selectedTables) . ' ' . $expression;

        $rows = $this->database->queryParams($query, $params);

        return $rows;
    }
}
