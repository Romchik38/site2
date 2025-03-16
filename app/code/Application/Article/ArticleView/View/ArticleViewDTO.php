<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleView\View;

/** Full info about Article */
final class ArticleViewDTO
{
    /** @param string[] $categories */
    public function __construct(
        public readonly string $articleId,
        public readonly string $name,
        public readonly string $shortDescription,
        public readonly string $description,
        public readonly array $categories,
        public readonly string $createdAt,
        public readonly AuthorDTO $author,
        public readonly ImageDTO $image,
        public readonly AudioDTO $audio
    ) {}
}
