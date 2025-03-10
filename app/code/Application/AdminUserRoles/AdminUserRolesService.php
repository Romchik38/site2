<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\AdminUserRoles;

use Romchik38\Site2\Domain\AdminUser\AdminUserRepositoryInreface;
use Romchik38\Site2\Domain\AdminUser\VO\Roles;
use Romchik38\Site2\Domain\AdminUser\VO\Username;
use InvalidArgumentException;
use Romchik38\Site2\Domain\AdminUser\AdminUserNotActiveException;

final class AdminUserRolesService
{
    public function __construct(
        protected readonly AdminUserRepositoryInreface $adminUserRepository
    ) {   
    }

    /**
     * @throws InvalidArgumentException - On wrong username format
     * @throws NoSuchAdminUserException
     * @throws AdminUserNotActiveException
     */
    public function listRolesByUsername(ListRoles $command): Roles
    {
        $username = new Username($command->username);
        $user = $this->adminUserRepository->findByUsername($username);
        if ($user->isActive() === false) {
            /** @todo test on ot active */
            throw new AdminUserNotActiveException(
                sprintf('Admin use with username %s not active', $username())
            );
        }
        /** @todo test data */
        return $user->roles();
    }
}