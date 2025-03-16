<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminArticleListView\View;

interface SearchCriteriaFactoryInterface
{
    public function create(
        string $offset,
        string $limit,
        string $orderByField,
        string $orderByDirection
    ): SearchCriteriaInterface;
}
