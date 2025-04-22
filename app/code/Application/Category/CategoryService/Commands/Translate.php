<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\CategoryService\Commands;

final class Translate
{
    public function __construct(
        public readonly string $language,
        public string $description,
        public string $name
    ) {
    }
}
