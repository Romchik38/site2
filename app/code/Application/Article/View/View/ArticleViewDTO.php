<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\View\View;

use DateTime;

/** Full info about Article */
final class ArticleViewDTO
{
    /** @param CategoryDTO[] $categories */
    public function __construct(
        public readonly string $articleId,
        public readonly string $name,
        public readonly string $shortDescription,
        public readonly string $description,
        public readonly array $categories,
        public readonly DateTime $createdAt,
        public readonly AuthorDTO $author,
        public readonly ImageDTO $image,
        public readonly AudioDTO $audio
    ) {
    }
}
