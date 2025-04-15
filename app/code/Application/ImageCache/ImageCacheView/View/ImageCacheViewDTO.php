<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImageCache\ImageCacheView\View;

use Romchik38\Site2\Domain\ImageCache\VO\Data;
use Romchik38\Site2\Domain\ImageCache\VO\Type;

final class ImageCacheViewDTO
{
    public function __construct(
        public readonly Type $type,
        public readonly Data $data
    ) {
    }

    public function type(): string
    {
        return ($this->type)();
    }

    public function data(): string
    {
        return ($this->data)();
    }
}
