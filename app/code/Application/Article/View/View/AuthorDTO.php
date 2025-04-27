<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\View\View;

final class AuthorDTO
{
    public function __construct(
        public readonly string $authorId,
        public readonly string $description
    ) {
    }
}
