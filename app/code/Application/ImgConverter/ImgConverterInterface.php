<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImgConverter;

interface ImgConverterInterface
{
    public function create(
        string $data,
        string $type,
        int $width,
        int $height
    ): string;
}
