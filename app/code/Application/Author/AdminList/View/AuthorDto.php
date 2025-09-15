<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminList\View;

use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name;

final readonly class AuthorDto
{
    public function __construct(
        public AuthorId $identifier,
        public Name $name,
        public bool $active
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'author_id'     => ($this->identifier)(),
            'author_active' => $this->active,
            'author_name'   => ($this->name)(),
        ];
    }
}
