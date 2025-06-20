<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\List\Commands\Filter;

final class ArticleDTO
{
    /** @param CategoryDTO[] $categories */
    public function __construct(
        public readonly string $articleId,
        public readonly string $name,
        public readonly string $shortDescription,
        public readonly array $categories,
        public readonly string $formattedCreatedAt,
        public readonly string $readLength,
        public readonly ImageDTO $image
    ) {
    }
}
