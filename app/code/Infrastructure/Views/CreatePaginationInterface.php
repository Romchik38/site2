<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views;

interface CreatePaginationInterface {
    public static function createPagination(
        int $page,
        int $limit,
        int $totalCount,
        int $displayed
    ): string;
}