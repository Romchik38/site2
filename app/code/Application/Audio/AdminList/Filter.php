<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminList;

use Romchik38\Site2\Infrastructure\Views\Html\PaginationInterface;

final class Filter
{
    public function __construct(
        public readonly string $limit,
        public readonly string $page,
        public readonly string $orderByField,
        public readonly string $orderByDirection,
    ) {
    }

    /** @param array<string,mixed> $hash */
    public static function fromRequest(array $hash): self
    {
        // Limit
        $limit = '';
        $rawLimit = $hash[PaginationInterface::LIMIT_FIELD] ?? '';
        if (is_string($rawLimit)) {
            $limit = $rawLimit;
        }

        // Page
        $page = '';
        $rawPage = $hash[PaginationInterface::PAGE_FIELD] ?? '';
        if (is_string($rawPage)) {
            $page = $rawPage;
        }

        // Order By
        $orderBy = '';
        $rawOrderBy = $hash[PaginationInterface::ORDER_BY_FIELD] ?? '';
        if (is_string($rawOrderBy)) {
            $orderBy = $rawOrderBy;
        }

        // Order By Direction
        $orderByDirection = '';
        $rawOrderByDirection = $hash[PaginationInterface::ORDER_BY_DIRECTION_FIELD] ?? '';
        if (is_string($rawOrderByDirection)) {
            $orderByDirection = $rawOrderByDirection;
        }

        return new self(
            $limit,
            $page,
            $orderBy,
            $orderByDirection
        );
    }
}
