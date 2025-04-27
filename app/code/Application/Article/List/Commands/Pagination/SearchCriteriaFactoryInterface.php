<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\List\Commands\Pagination;

interface SearchCriteriaFactoryInterface
{
    public function create(
        string $offset,
        string $limit,
        string $orderByField,
        string $orderByDirection,
        string $language
    ): SearchCriteriaInterface;
}
