<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\View\View;

final readonly class AuthorDTO
{
    public function __construct(
        public string $authorId,
        public string $description
    ) {
    }
}
