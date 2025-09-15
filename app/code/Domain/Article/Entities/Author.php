<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\Entities;

use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name;

final readonly class Author
{
    public function __construct(
        public AuthorId $id,
        public bool $active,
        public Name $name
    ) {
    }
}
