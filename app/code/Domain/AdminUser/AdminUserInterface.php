<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser;

use Romchik38\Site2\Domain\AdminUser\VO\Active;
use Romchik38\Site2\Domain\AdminUser\VO\Identifier;
use Romchik38\Site2\Domain\AdminUser\VO\Password;

interface AdminUserInterface
{
    public function checkPassword(Password $password): bool;

    public function isActive(): bool;

    public function identifier(): Identifier;
}