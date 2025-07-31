<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\ArticleSearch\View;

use Romchik38\Site2\Domain\Author\VO\Name;

final class AuthorDto
{
    public function __construct(
        public readonly Name $name
    ) {
    }

    public function getName(): string
    {
        return (string) $this->name;
    }
}
