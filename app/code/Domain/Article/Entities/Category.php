<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\Entities;

use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;

final readonly class Category
{
    public function __construct(
        public CategoryId $id,
        public bool $active,
        public int $articleCount
    ) {
    }
}
