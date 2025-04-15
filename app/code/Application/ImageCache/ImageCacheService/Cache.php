<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImageCache\ImageCacheService;

final class Cache
{
    public function __construct(
        public readonly string $key,
        public readonly string $data,
        public readonly string $type
    ) {
    }
}
