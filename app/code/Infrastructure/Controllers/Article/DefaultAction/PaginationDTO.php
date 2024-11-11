<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction;

final class PaginationDTO {
    public function __construct(
        public readonly int $limit,
        public readonly int $offset,
        public readonly int $displayed,
        public readonly int $totalCount,
    ){
    }
}