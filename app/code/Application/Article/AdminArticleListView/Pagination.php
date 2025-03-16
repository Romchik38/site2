<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminArticleListView;

final class Pagination
{

    public function __construct(
        protected string $limit,
        protected string $offset,
        protected string $orderByField,
        protected string $orderByDirection
    ) {}

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
