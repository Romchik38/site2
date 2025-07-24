<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ContinueReading\View;

final class Item
{
    public function __construct(
        public string $first,
        public ?string $second = null
    ) {
    }
}
