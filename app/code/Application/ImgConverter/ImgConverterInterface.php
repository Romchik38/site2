<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImgConverter;

use Romchik38\Site2\Application\ImgConverter\View\Height;
use Romchik38\Site2\Application\ImgConverter\View\ImgResult;
use Romchik38\Site2\Application\ImgConverter\View\Type;
use Romchik38\Site2\Application\ImgConverter\View\Width;

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
