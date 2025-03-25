<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminList\View;

use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name;

final class AuthorDto
{
    public readonly AuthorId $identifier;
    public readonly Name $name;

    public function __construct(
        string $id,
        string $name,
        public readonly bool $active
    ) {
        $this->identifier = new AuthorId($id);
        $this->name       = new Name($name);
    }
}
