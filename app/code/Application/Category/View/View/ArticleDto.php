<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\View\View;

final class ArticleDto
{
    /** @param ArticleCategoryDto[] $categories */
    public function __construct(
        public readonly string $articleId,
        public readonly string $name,
        public readonly string $shortDescription,
        public readonly array $categories,
        public readonly string $formattedCreatedAt,
        public readonly string $readLength,
        public readonly ImageDto $image
    ) {
    }
}
