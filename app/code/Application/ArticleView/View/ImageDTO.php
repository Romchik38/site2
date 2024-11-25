<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleView\View;

final class ImageDTO
{
    public function __construct(
        public readonly string $img_id,
        public readonly string $path,
        public readonly string $description
    ) {}
}
