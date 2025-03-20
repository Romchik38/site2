<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminAuthorList\View;

use Romchik38\Site2\Domain\Author\VO\Name;

final class AuthorDto
{
    public readonly Name $name;

    public function __construct(
        string $name,
    ) {
        $this->name = new Name($name);
    }
}
