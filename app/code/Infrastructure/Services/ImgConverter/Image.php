<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\ImgConverter;

use Romchik38\Site2\Application\ImgConverter\View\Height;
use Romchik38\Site2\Application\ImgConverter\View\Type;
use Romchik38\Site2\Application\ImgConverter\View\Width;

final class Image
{
    protected readonly int $originalWidth;
    protected readonly int $originalHeight;
    protected readonly string $originalType;
    protected readonly int $copyWidth;
    protected readonly int $copyHeight;
    protected readonly string $copyType;

    public function __construct(
        protected readonly string $filePath,
        Width $copyWidth,
        Height $copyHeight,
        Type $copyType,
    ) {
        $this->copyWidth = $copyWidth();
        $this->copyHeight = $copyHeight();
        $this->copyType = $copyType();
    }
}
