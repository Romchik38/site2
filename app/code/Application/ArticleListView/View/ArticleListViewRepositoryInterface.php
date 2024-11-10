<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleListView\View;

use Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaInterface;

interface ArticleListViewRepositoryInterface
{
    public function list(SearchCriteriaInterface $searchCriteria): array;
}
