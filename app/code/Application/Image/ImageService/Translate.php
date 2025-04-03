<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImageService;

final class Translate
{
    public function __construct(
        public readonly string $language,
        public readonly string $description
    ) {
    }
}
