<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\View\View;

final readonly class ImageDto
{
    public function __construct(
        public string $imgId,
        public string $path,
        public string $description
    ) {
    }
}
