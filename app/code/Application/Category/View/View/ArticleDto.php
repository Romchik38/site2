<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\View\View;

use DateTime;

final class ArticleDto
{
    /** @param ArticleCategoryDto[] $categories */
    public function __construct(
        public readonly string $articleId,
        public readonly string $name,
        public readonly string $shortDescription,
        public readonly string $description,
        public readonly array $categories,
        public readonly DateTime $createdAt,
        public readonly ImageDto $image
    ) {
    }
}
