<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\Entities;

use GdImage;
use Romchik38\Site2\Domain\Image\VO\Height;
use Romchik38\Site2\Domain\Image\VO\Size;
use Romchik38\Site2\Domain\Image\VO\Type;
use Romchik38\Site2\Domain\Image\VO\Width;

final readonly class Content
{
    public function __construct(
        private GdImage $data,
        private Type $type,
        private Height $height,
        private Width $width,
        private Size $size
    ) {
    }

    public function getData(): GdImage
    {
        return $this->data;
    }

    public function getHeight(): Height
    {
        return $this->height;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getSize(): Size
    {
        return $this->size;
    }

    public function getWidth(): Width
    {
        return $this->width;
    }
}
