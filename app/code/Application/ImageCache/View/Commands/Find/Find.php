<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImageCache\View\Commands\Find;

final class Find
{
    public function __construct(
        private readonly string $key
    ) {
    }

    public function key(): string
    {
        return $this->key;
    }
}
