<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleListView;

final class Pagination
{
    public const LIMIT_FIELD = 'limit';
    public const OFFSET_FIELD = 'offset';
    public const ORDER_BY_FIELD = 'offset';
    public const ORDER_BY_DIRECTION = 'offset';

    public function __construct(
        protected string $limit,
        protected string $offset,
        protected string $orderByField,
        protected string $orderByDirection
    ) {}

    public static function fromRequest(array $hash): self
    {
        return new self(
            $hash[self::LIMIT_FIELD] ?? '',
            $hash[self::OFFSET_FIELD] ?? '',
            $hash[self::ORDER_BY_FIELD] ?? '',
            $hash[self::ORDER_BY_DIRECTION] ?? ''
        );
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
