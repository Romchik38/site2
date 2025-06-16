<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Banner\Entities;

use Romchik38\Site2\Domain\Image\VO\Id;

final class Image
{
    public function __construct(
        public readonly Id $id,
        public readonly bool $active
    ) {
    }
}
