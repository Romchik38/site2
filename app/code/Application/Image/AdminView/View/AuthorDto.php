<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView\View;

use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name;

final readonly class AuthorDto
{
    public function __construct(
        public AuthorId $id,
        public Name $name,
        public bool $active
    ) {
    }
}
