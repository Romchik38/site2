<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\View\View;

use DateTime;

final readonly class ArticleDto
{
    /** @param ArticleCategoryDto[] $categories */
    public function __construct(
        public string $articleId,
        public string $name,
        public string $shortDescription,
        public string $description,
        public array $categories,
        public DateTime $createdAt,
        public ImageDto $image
    ) {
    }
}
