<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser\Entities;

use Romchik38\Site2\Domain\AdminRole\VO\Description;
use Romchik38\Site2\Domain\AdminRole\VO\Identifier;
use Romchik38\Site2\Domain\AdminRole\VO\Name;

final class Role
{
    public function __construct(
        private readonly Identifier $id,
        private readonly Name $name,
        private readonly Description $description
    ) {
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getId(): Identifier
    {
        return $this->id;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }
}
