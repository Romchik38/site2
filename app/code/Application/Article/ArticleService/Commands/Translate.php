<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleService\Commands;

final class Translate
{
    public function __construct(
        public readonly string $language,
        public readonly string $shortDescription,
        public readonly string $description,
        public readonly string $name
    ) {
    }
}
