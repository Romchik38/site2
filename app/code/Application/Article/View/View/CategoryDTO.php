<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\View\View;

use Romchik38\Site2\Domain\Category\VO\Identifier;
use Romchik38\Site2\Domain\Category\VO\Name;

final readonly class CategoryDTO
{
    public function __construct(
        public Identifier $id,
        public Name $name
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }
}
