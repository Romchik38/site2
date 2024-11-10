<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleListView\View;

interface ArticleListViewRepositoryInterface
{
    public function list(SearchCriteriaInterface $searchCriteria): array;
}
