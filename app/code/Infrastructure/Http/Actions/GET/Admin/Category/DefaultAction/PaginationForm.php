<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\DefaultAction;

use Romchik38\Site2\Application\Category\AdminList\VO\Limit;
use Romchik38\Site2\Application\Category\AdminList\VO\OrderByDirection;
use Romchik38\Site2\Application\Category\AdminList\VO\OrderByField;

final class PaginationForm
{
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
        $limits       = [];
        $currentLimit = ($this->limit)();
        foreach (Limit::ALLOWED_LIMITS as $limit) {
            if ($limit !== $currentLimit) {
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
        $orderBys       = [];
        $currentOrderBy = ($this->orderBy)();
        foreach ($this->orderBy::ALLOWED_ORDER_BY as $orderBy) {
            if ($orderBy !== $currentOrderBy) {
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
        $orderByDirections       = [];
        $currentOrderByDirection = ($this->orderByDirection)();
        foreach (OrderByDirection::ALLOWED_ORDER_BY_DIRECTIONS as $orderByDirection) {
            if ($orderByDirection !== $currentOrderByDirection) {
                $orderByDirections[] = $orderByDirection;
            }
        }
        return $orderByDirections;
    }
}
