<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Category\Entities;

use Romchik38\Site2\Domain\Article\VO\Identifier;

final class Article
{
    public function __construct(
        public readonly Identifier $id,
        public readonly bool $active
    ) {
    }
}
