<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\SearchCriteria;

interface SearchCriteriaFactoryInterface
{
    /** @param array<int,OrderByInterface> $orderBy */
    public function create(
        string $limit,
        string $offset,
        array $orderBy = []
    ): SearchCriteriaInterface;
}
