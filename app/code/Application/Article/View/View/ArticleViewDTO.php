<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\View\View;

use DateTime;

/** Full info about Article */
final readonly class ArticleViewDTO
{
    /** @param CategoryDTO[] $categories */
    public function __construct(
        public string $articleId,
        public string $name,
        public string $shortDescription,
        public string $description,
        public array $categories,
        public DateTime $createdAt,
        public AuthorDTO $author,
        public ImageDTO $image,
        public AudioDTO $audio
    ) {
    }
}
