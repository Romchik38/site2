<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImgConverter;

use Romchik38\Site2\Application\Image\ImgConverter\View\Height;
use Romchik38\Site2\Application\Image\ImgConverter\View\ImgResult;
use Romchik38\Site2\Domain\Image\VO\Type;
use Romchik38\Site2\Application\Image\ImgConverter\View\Width;

interface ImgConverterInterface
{
    /** @throws CouldNotCreateImageException */
    public function create(
        string $filePath,
        Width $copyWidth,
        Height $copyHeight,
        Type $copyType
    ): ImgResult;
}
