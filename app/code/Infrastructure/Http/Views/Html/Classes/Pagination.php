<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html\Classes;

use Romchik38\Site2\Infrastructure\Http\Views\Html\PaginationInterface;

final class Pagination implements PaginationInterface
{
    public function __construct(
        private string $limit,
        private string $page,
        private string $orderByField,
        private string $orderByDirection,
        private int $totalCount
    ) {
    }

    public function limit(): string
    {
        return $this->limit;
    }

    public function page(): string
    {
        return $this->page;
    }

    public function orderByField(): string
    {
        return $this->orderByField;
    }

    public function orderByDirection(): string
    {
        return $this->orderByDirection;
    }

    public function totalCount(): int
    {
        return $this->totalCount;
    }
}
