<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\List\Commands\Pagination;

final class Pagination
{
    public function __construct(
        private string $limit,
        private string $offset,
        private string $orderByField,
        private string $orderByDirection
    ) {
    }

    public function limit(): string
    {
        return $this->limit;
    }

    public function offset(): string
    {
        return $this->offset;
    }

    public function orderByField(): string
    {
        return $this->orderByField;
    }

    public function orderByDirection(): string
    {
        return $this->orderByDirection;
    }
}
