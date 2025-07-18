<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AuthorService\Commands;

final class Translate
{
    public function __construct(
        public readonly string $language,
        public readonly string $description
    ) {
    }
}
