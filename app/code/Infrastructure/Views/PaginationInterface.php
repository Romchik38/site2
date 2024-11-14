<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views;

interface PaginationInterface
{
    public function limit(): string;

    public function page(): string;

    public function orderByField(): string;

    public function orderByDirection(): string;

    public function totalCount(): int;
}
