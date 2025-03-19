<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser\VO;

use Romchik38\Site2\Domain\AdminRole\VO\Description;
use Romchik38\Site2\Domain\AdminRole\VO\Identifier;
use Romchik38\Site2\Domain\AdminRole\VO\Name;

final class Role
{
    public function __construct(
        protected readonly Identifier $identifier,
        protected readonly Name $name,
        protected readonly Description $description
    ) {
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function identifier(): Identifier
    {
        return $this->identifier;
    }

    public function description(): Description
    {
        return $this->description;
    }
}
