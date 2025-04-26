<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\AdminUser\AdminUserService;

use InvalidArgumentException;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Commands\CheckPassword;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Commands\CheckRoles;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Exceptions\AdminUserNotActiveException;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Exceptions\CouldNotCheckPasswordException;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Exceptions\CouldNotCheckRolesException;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Exceptions\NoSuchAdminUserException;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Exceptions\RepositoryException;
use Romchik38\Site2\Domain\AdminUser\VO\Password;
use Romchik38\Site2\Domain\AdminUser\VO\Username;

use function sprintf;

final class AdminUserService
{
    public function __construct(
        protected readonly RepositoryInterface $adminUserRepository
    ) {
    }

    /**
     * @throws AdminUserNotActiveException
     * @throws CouldNotCheckPasswordException
     * @throws InvalidPasswordException
     * @throws InvalidArgumentException
     * @throws NoSuchAdminUserException
     */
    public function checkPassword(CheckPassword $command): Username
    {
        $username = new Username($command->username);
        $password = new Password($command->password);

        try {
            $user = $this->adminUserRepository->findByUsername($username);
        } catch (RepositoryException $e) {
            throw new CouldNotCheckPasswordException($e->getMessage());
        }

        $result = $user->checkPassword($password);
        if ($result === true) {
            if ($user->isActive() === false) {
                throw new AdminUserNotActiveException(
                    sprintf('Admin user with username %s not active', $username())
                );
            }
            return $user->getUsername();
        }
        throw new InvalidPasswordException(
            sprintf('Password for username %s is incorrect', $username())
        );
    }

    /**
     * @throws AdminUserNotActiveException
     * @throws CouldNotCheckRolesException
     * @throws InvalidArgumentException
     * @throws NoSuchAdminUserException
     * */
    public function checkRoles(CheckRoles $command): bool
    {
        $username = new Username($command->username);

        try {
            $user = $this->adminUserRepository->findByUsername($username);
        } catch (RepositoryException $e) {
            throw new CouldNotCheckRolesException($e->getMessage());
        }

        if ($user->isActive() === false) {
            throw new AdminUserNotActiveException(
                sprintf('Admin user with username %s not active', $username())
            );
        }

        //$adminRoles = $user->getRoles();

        if ($command->method === CheckRoles::FIRST_MATCH) {
            foreach ($command->roles as $role) {
                if ($user->hasRole($role)) {
                    return true;
                }
            }
            return false;
        } elseif ($command->method === CheckRoles::ALL) {
            foreach ($command->roles as $role) {
                if (! $user->hasRole($role)) {
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
