<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImgConverter;

use Romchik38\Site2\Application\Image\ImgConverter\View\Height;
use Romchik38\Site2\Application\Image\ImgConverter\View\ImgResult;
use Romchik38\Site2\Application\Image\ImgConverter\View\Width;
use Romchik38\Site2\Domain\Image\VO\Path;
use Romchik38\Site2\Domain\Image\VO\Type;

interface ImageStorageInterface
{
    /** @throws CouldNotCreateImageException */
    public function makeCopy(
        Path $path,
        Width $copyWidth,
        Height $copyHeight,
        Type $copyType
    ): ImgResult;
}
