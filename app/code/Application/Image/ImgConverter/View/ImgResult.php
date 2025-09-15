<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImgConverter\View;

final readonly class ImgResult
{
    public function __construct(
        public string $type,
        public string $data
    ) {
    }
}
