<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleListView\View;

interface ArticleListViewRepositoryInterface
{
    /** list active article by language */
    public function list(SearchCriteriaInterface $searchCriteria): array;

    /** count of all active article */
    public function totalCount(): int;

}
