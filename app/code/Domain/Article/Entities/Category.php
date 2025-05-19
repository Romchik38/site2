<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\Entities;

use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;

final class Category
{
    public function __construct(
        public readonly CategoryId $categoryId,
        public readonly bool $active
    ) {
    }
}
