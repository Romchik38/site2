<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser;

use Romchik38\Site2\Domain\AdminUser\VO\Identifier;
use Romchik38\Site2\Domain\AdminUser\VO\Password;
use Romchik38\Site2\Domain\AdminUser\VO\Roles;
use Romchik38\Site2\Domain\AdminUser\VO\Username;

interface AdminUserInterface
{
    public function checkPassword(Password $password): bool;

    public function isActive(): bool;

    public function identifier(): Identifier;

    public function username(): Username;

    public function roles(): Roles;
}