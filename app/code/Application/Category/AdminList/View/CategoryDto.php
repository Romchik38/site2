<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\AdminList\View;

use Romchik38\Site2\Domain\Category\VO\Identifier;

final readonly class CategoryDto
{
    public function __construct(
        public Identifier $id,
        public bool $active
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }
}
