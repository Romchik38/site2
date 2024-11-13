<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views;

interface CreatePaginationInterface {
    public function create(
        int $page,
        int $limit,
        int $totalCount,
        int $displayed
    ): string;
}