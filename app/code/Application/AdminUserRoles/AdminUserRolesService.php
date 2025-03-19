<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\AdminUserRoles;

use InvalidArgumentException;
use Romchik38\Site2\Domain\AdminUser\AdminUserNotActiveException;
use Romchik38\Site2\Domain\AdminUser\AdminUserRepositoryInterface;
use Romchik38\Site2\Domain\AdminUser\VO\Roles;
use Romchik38\Site2\Domain\AdminUser\VO\Username;

use function sprintf;

final class AdminUserRolesService
{
    public function __construct(
        protected readonly AdminUserRepositoryInterface $adminUserRepository
    ) {
    }

    /**
     * @throws InvalidArgumentException - On wrong username format.
     * @throws NoSuchAdminUserException
     * @throws AdminUserNotActiveException
     */
    public function listRolesByUsername(ListRoles $command): Roles
    {
        $username = new Username($command->username);
        $user     = $this->adminUserRepository->findByUsername($username);
        if ($user->isActive() === false) {
            throw new AdminUserNotActiveException(
                sprintf('Admin use with username %s not active', $username())
            );
        }
        return $user->roles();
    }
}
