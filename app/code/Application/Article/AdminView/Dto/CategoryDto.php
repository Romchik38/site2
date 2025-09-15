<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminView\Dto;

use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;

final readonly class CategoryDto
{
    public function __construct(
        public CategoryId $id,
        public bool $active
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }
}
