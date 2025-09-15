<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\Entities;

use Romchik38\Site2\Domain\Author\VO\AuthorId;

final readonly class Author
{
    public function __construct(
        public AuthorId $id,
        public bool $active
    ) {
    }
}
