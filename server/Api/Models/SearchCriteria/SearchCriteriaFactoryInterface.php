<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\SearchCriteria;

interface SearchCriteriaFactoryInterface
{
    public function create(
        string $limit,
        string $offset = '0',
        array $orderBy = []
    ): SearchCriteriaInterface;
}
