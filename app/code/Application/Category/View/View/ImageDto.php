<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\View\View;

final class ImageDto
{
    public function __construct(
        public readonly string $imgId,
        public readonly string $path,
        public readonly string $description
    ) {
    }
}
