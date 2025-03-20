<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminList;

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

    /** @param array<string,string> $hash */
    public static function fromRequest(array $hash): self
    {
        return new self(
            $hash[PaginationInterface::LIMIT_FIELD] ?? '',
            $hash[PaginationInterface::PAGE_FIELD] ?? '',
            $hash[PaginationInterface::ORDER_BY_FIELD] ?? '',
            $hash[PaginationInterface::ORDER_BY_DIRECTION_FIELD] ?? ''
        );
    }
}
