<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\List\Commands\Pagination;

final class ImageDTO
{
    public function __construct(
        public readonly string $imgId,
        public readonly string $path,
        public readonly string $description
    ) {
    }
}
