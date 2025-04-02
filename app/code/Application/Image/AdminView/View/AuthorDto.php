<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView\View;

use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Author\VO\AuthorId;

final class AuthorDto
{
    public function __construct(
        public readonly AuthorId $id,
        public readonly Name $name,
        public readonly bool $active
    ) {   
    }
}