<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImageCacheView;

final class Find
{
    public function __construct(
        protected readonly string $key
    ) {
    }

    public function key(): string
    {
        return $this->key;
    }
}
