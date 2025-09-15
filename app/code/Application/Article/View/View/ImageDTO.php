<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\View\View;

final readonly class ImageDTO
{
    public function __construct(
        public string $imgId,
        public string $path,
        public string $description,
        public string $author,
    ) {
    }
}
