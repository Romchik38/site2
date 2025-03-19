<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleView\View;

final class ArticleIdNameDTO
{
    public function __construct(
        public readonly string $articleId,
        public readonly string $name
    ) {
    }
}
