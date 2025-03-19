<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\AdminUserCheck;

use InvalidArgumentException;
use Romchik38\Site2\Domain\AdminUser\AdminUserNotActiveException;
use Romchik38\Site2\Domain\AdminUser\AdminUserRepositoryInterface;
use Romchik38\Site2\Domain\AdminUser\NoSuchAdminUserException;
use Romchik38\Site2\Domain\AdminUser\VO\Password;
use Romchik38\Site2\Domain\AdminUser\VO\Username;

use function sprintf;

final class AdminUserCheckService
{
    public function __construct(
        protected readonly AdminUserRepositoryInterface $adminUserRepository
    ) {
    }

    /**
     * @throws AdminUserNotActiveException
     * @throws InvalidPasswordException
     * @throws InvalidArgumentException
     * @throws NoSuchAdminUserException
     */
    public function checkPassword(CheckPassword $command): Username
    {
        $username = new Username($command->username);
        $password = new Password($command->password);

        $user   = $this->adminUserRepository->findByUsername($username);
        $result = $user->checkPassword($password);
        if ($result === true) {
            if ($user->isActive() === false) {
                throw new AdminUserNotActiveException(
                    sprintf('Admin use with username %s not active', $username())
                );
            }
            return $user->username();
        }
        throw new InvalidPasswordException(
            sprintf('Password for username %s is incorrect', $username())
        );
    }
}
