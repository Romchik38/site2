<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DefaultAction;

use InvalidArgumentException;
use Romchik38\Site2\Infrastructure\Views\Html\PaginationInterface;

final class Pagination implements PaginationInterface
{

    public const DEFAULT_LIMIT = '15';
    public const ALLOWED_LIMITS = ['2', '5', '15', '30'];

    public const DEFAULT_PAGE = '1';

    public const DEFAULT_ORDER_BY = 'created_at';
    public const ALLOWED_ORDER_BYS = ['created_at', 'identifier'];

    public const DEFAULT_ORDER_BY_DIRECTION = 'desc';
    public const ALLOWED_ORDER_BY_DIRECTIONS = ['asc', 'desc'];

    public readonly string $offset;

    public function __construct(
        protected string $limit,
        protected string $page,
        protected string $orderByField,
        protected string $orderByDirection,
        protected int $totalCount
    ) {
        // Limit for now 15 or 30
        if ($limit === '') {
            $this->limit = $this::DEFAULT_LIMIT;
        } else {
            if (in_array($limit, $this::ALLOWED_LIMITS) === false) {
                throw new InvalidArgumentException(
                    sprintf('param limit %s is invalid', $limit)
                );
            }
        }

        // Set page 
        if ($page === '') {
            $this->page = $this::DEFAULT_PAGE;
        } else {
            $pageInt = (int)$page;
            if (
                $pageInt <= 0
                || ($pageInt - 1) * (int)$this->limit > $totalCount
            ) {
                throw new InvalidArgumentException(
                    sprintf('param page %s is invalid', $page)
                );
            }
        }

        // Order by
        if ($orderByField === '') {
            $this->orderByField = $this::DEFAULT_ORDER_BY;
        } else {
            if (in_array($orderByField, $this::ALLOWED_ORDER_BYS) === false) {
                throw new InvalidArgumentException(
                    sprintf('param order by field %s is invalid', $orderByField)
                );
            }
        }

        // Order by Direction
        if ($orderByDirection === '') {
            $this->orderByDirection = $this::DEFAULT_ORDER_BY_DIRECTION;
        } else {
            if (in_array($orderByDirection, $this::ALLOWED_ORDER_BY_DIRECTIONS) === false) {
                throw new InvalidArgumentException(
                    sprintf('param order by direction %s is invalid', $orderByDirection)
                );
            }
        }

        // Offset
        $this->offset = (string)(((int)$this->page() - 1) * (int)$this->limit);
    }

    /** @param array<string,string> $hash */
    public static function fromRequest(array $hash, int $totalCount): self
    {
        return new self(
            $hash[self::LIMIT_FIELD] ?? '',
            $hash[self::PAGE_FIELD] ?? '',
            $hash[self::ORDER_BY_FIELD] ?? '',
            $hash[self::ORDER_BY_DIRECTION_FIELD] ?? '',
            $totalCount
        );
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
