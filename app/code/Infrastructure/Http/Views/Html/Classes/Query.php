<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html\Classes;

final readonly class Query
{
    public function __construct(
        public string $key,
        public string $value,
    ) {
    }
}
