<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImgConverter\View;

final class ImgResult
{
    public function __construct(
        public readonly string $type,
        public readonly string $data
    ) {}
}
