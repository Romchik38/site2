<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\Article\View;

use Romchik38\Site2\Domain\Author\VO\Description;

final class AuthorDto
{
    public function __construct(
        public readonly Description $description
    ) {
    }

    public function getDescription(): string
    {
        return (string) $this->description;
    }
}
