<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\List\View;

use Romchik38\Site2\Domain\Category\VO\Description;
use Romchik38\Site2\Domain\Category\VO\Identifier;
use Romchik38\Site2\Domain\Category\VO\Name;

final readonly class CategoryDto
{
    public function __construct(
        public Identifier $id,
        public Name $name,
        public Description $description,
        public int $totalCount
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

    public function getDescription(): string
    {
        return (string) $this->description;
    }
}
