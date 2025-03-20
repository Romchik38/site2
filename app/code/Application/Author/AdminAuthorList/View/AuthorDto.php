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

    // public function nameAsString(): string
    // {
    //     return ($this->name)();
    // }

    // public function authorNameAsString(): string
    // {
    //     return ($this->authorName)();
    // }

    // public function identifierAsString(): string
    // {
    //     return ($this->identifier)();
    // }

    // public function pathAsString(): string
    // {
    //     return ($this->path)();
    // }
}
