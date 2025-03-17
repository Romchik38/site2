<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views\Html;

interface PaginationInterface
{
    public const LIMIT_FIELD = 'limit';
    public const PAGE_FIELD = 'page';
    public const ORDER_BY_FIELD = 'order_by';
    public const ORDER_BY_DIRECTION_FIELD = 'order_direction';
    
    public function limit(): string;
    public function page(): string;
    public function orderByField(): string;
    public function orderByDirection(): string;
    public function totalCount(): int;
}
