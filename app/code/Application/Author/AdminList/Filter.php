<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminList;

final class Filter
{
    public const LIMIT_FIELD              = 'limit';
    public const PAGE_FIELD               = 'page';
    public const ORDER_BY_FIELD           = 'order_by';
    public const ORDER_BY_DIRECTION_FIELD = 'order_direction';

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
            $hash[self::LIMIT_FIELD] ?? '',
            $hash[self::PAGE_FIELD] ?? '',
            $hash[self::ORDER_BY_FIELD] ?? '',
            $hash[self::ORDER_BY_DIRECTION_FIELD] ?? ''
        );
    }
}
