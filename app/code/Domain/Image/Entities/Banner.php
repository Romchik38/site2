<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\Entities;

use Romchik38\Site2\Domain\Banner\VO\Identifier;

final readonly class Banner
{
    public function __construct(
        public Identifier $id,
        public bool $active
    ) {
    }
}
