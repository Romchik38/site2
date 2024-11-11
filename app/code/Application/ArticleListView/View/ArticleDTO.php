<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleListView\View;

final class ArticleDTO
{
    public function __construct(
        public readonly string $articleId,
        public readonly string $name,
        public readonly string $shortDescription,
        public readonly string $description,
        public readonly array $categories,
        public readonly string $formattedCreatedAt,
        public readonly string $readLength
    ) {}

}
