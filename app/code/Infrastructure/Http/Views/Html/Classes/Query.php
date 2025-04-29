<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html\Classes;

final class Query
{
    public function __construct(
        public readonly string $key,
        public readonly string $value,
    ) {
    }
}
