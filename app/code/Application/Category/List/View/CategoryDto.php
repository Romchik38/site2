<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\List\View;

use Romchik38\Site2\Domain\Category\VO\Description;
use Romchik38\Site2\Domain\Category\VO\Identifier;
use Romchik38\Site2\Domain\Category\VO\Name;

final class CategoryDto
{
    public function __construct(
        public readonly Identifier $id,
        public readonly Name $name,
        public readonly Description $description,
        public readonly int $totalCount
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
