<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\AdminUser\AdminUserService;

use Romchik38\Site2\Application\AdminUser\AdminUserService\Exceptions\NoSuchAdminUserException;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Exceptions\RepositoryException;
use Romchik38\Site2\Domain\AdminUser\AdminUser;
use Romchik38\Site2\Domain\AdminUser\VO\Username;

interface RepositoryInterface
{
    /**
     * @throws NoSuchAdminUserException
     * @throws RepositoryException
     * */
    public function findByUsername(Username $username): AdminUser;
}
