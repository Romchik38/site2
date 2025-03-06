<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser;

use Romchik38\Site2\Domain\AdminUser\VO\Username;

interface AdminUserRepositoryInreface
{
    /** @throws NoSuchAdminUserException */
    public function findByUsername(Username $username): AdminUserInterface;
}
