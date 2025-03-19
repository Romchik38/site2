<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views\Html\Classes;

use Romchik38\Site2\Infrastructure\Views\Html\PaginationInterface;

final class Pagination implements PaginationInterface
{
    public function __construct(
        protected string $limit,
        protected string $page,
        protected string $orderByField,
        protected string $orderByDirection,
        protected int $totalCount
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
