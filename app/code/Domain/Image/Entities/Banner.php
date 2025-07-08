<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\Entities;

use Romchik38\Site2\Domain\Banner\VO\Identifier;

final class Banner
{
    public function __construct(
        public readonly Identifier $id,
        public readonly bool $active
    ) {
    }
}
