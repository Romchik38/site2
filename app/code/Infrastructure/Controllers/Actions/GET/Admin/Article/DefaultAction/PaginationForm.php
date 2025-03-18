<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Article\DefaultAction;

use Romchik38\Site2\Application\Article\AdminArticleListView\VO\Limit;
use Romchik38\Site2\Application\Article\AdminArticleListView\VO\OrderByDirection;
use Romchik38\Site2\Application\Article\AdminArticleListView\VO\OrderByField;

final class PaginationForm
{
    /** @param array<int,int> $limits */
    /** @param array<int,string> $orderBys */
    /** @param array<int,string> $directions */
    public function __construct(
        public readonly Limit $limit,
        public readonly OrderByField $orderBy,
        public readonly OrderByDirection $orderByDirection
    ) {
    }

    public function currentLimit(): int
    {
        return ($this->limit)();
    }

    /** @return array<int,int> */
    public function limits(): array
    {
        $limits = [];
        $currentLimit = ($this->limit)();
        foreach ($this->limit::ALLOWED_LIMITS as $limit) {
            if($limit !== $currentLimit) {
                $limits[] = $limit;
            }
        }
        return $limits;
    }

    public function currentOrderBy(): string
    {
        return ($this->orderBy)();
    }

    /** @return array<int,string> */
    public function orderBys(): array
    {
        $orderBys = [];
        $currentOrderBy = ($this->orderBy)();
        foreach ($this->orderBy::ALLOWED_ORDER_BY as $orderBy) {
            if($orderBy !== $currentOrderBy) {
                $orderBys[] = $orderBy;
            }
        }
        return $orderBys;
    }

    public function currentOrderByDirection(): string
    {
        return ($this->orderByDirection)();
    }

    /** @return array<int,string> */
    public function orderByDirections(): array
    {
        $orderByDirections = [];
        $currentOrderByDirection = ($this->orderByDirection)();
        foreach ($this->orderByDirection::ALLOWED_ORDER_BY_DIRECTIONS as $orderByDirection) {
            if($orderByDirection !== $currentOrderByDirection) {
                $orderByDirections[] = $orderByDirection;
            }
        }
        return $orderByDirections;
    }
}