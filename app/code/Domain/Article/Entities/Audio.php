<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\Entities;

use Romchik38\Site2\Domain\Audio\VO\Id;

final readonly class Audio
{
    public function __construct(
        public Id $id,
        public bool $active
    ) {
    }
}
