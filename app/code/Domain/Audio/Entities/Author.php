<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio\Entities;

use Romchik38\Site2\Domain\Author\VO\AuthorId;

final class Author
{
    public function __construct(
        public readonly AuthorId $id,
        public readonly bool $active
    ) {
    }
}
