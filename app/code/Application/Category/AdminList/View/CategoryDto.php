<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\AdminList\View;

use Romchik38\Site2\Domain\Category\VO\Identifier;

final class CategoryDto
{
    public function __construct(
        public readonly Identifier $id
    ) {
    }
}
