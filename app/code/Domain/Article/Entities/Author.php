<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\Entities;

use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name;

final class Author
{
    public function __construct(
        public readonly AuthorId $id,
        public readonly bool $active,
        public readonly Name $name
    ) {
    }
}
