<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\Entities;

use GdImage;
use Romchik38\Site2\Domain\Image\VO\Type;

final class Content
{
    public function __construct(
        private GdImage $data,
        private Type $type
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
}
