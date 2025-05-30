<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\CategoryService\Commands;

final class Translate
{
    public function __construct(
        public readonly string $language,
        public readonly string $description,
        public readonly string $name
    ) {
    }
}
