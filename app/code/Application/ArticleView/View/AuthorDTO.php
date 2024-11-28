<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleView\View;

final class AuthorDTO
{
    public function __construct(
        public readonly string $author_id,
        public readonly string $description
    ) {}
}
