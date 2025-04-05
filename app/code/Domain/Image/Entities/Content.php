<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\Entities;

use GdImage;
use Romchik38\Site2\Domain\Image\VO\Type;
use Romchik38\Site2\Domain\Image\VO\Height;
use Romchik38\Site2\Domain\Image\VO\Width;

final class Content
{
    public function __construct(
        private readonly GdImage $data,
        private readonly Type $type,
        private readonly Height $height,
        private readonly Width $width
    ) {
    }

    public function getData(): GdImage
    {
        return $this->data;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getHeight(): Height
    {
        return $this->height;
    }

    public function getWidth(): Width
    {
        return $this->width;
    }
}
