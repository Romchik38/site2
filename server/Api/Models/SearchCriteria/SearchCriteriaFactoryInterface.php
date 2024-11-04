<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\SearchCriteria;

interface SearchCriteriaFactoryInterface
{
    public function create(
        string $limit,
        string $offset,
        array $orderBy = []
    ): SearchCriteriaInterface;
}
