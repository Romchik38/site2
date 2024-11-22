<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImgConverter;

use Romchik38\Site2\Infrastructure\Services\ImgConverter\Image;

interface ImgConverterInterface
{
    public function create(Image $img): string;
}
