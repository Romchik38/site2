<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\AdminUserCheck;

use Romchik38\Site2\Domain\AdminUser\VO\Identifier;
use Romchik38\Site2\Domain\AdminUser\VO\Password;
use Romchik38\Site2\Domain\AdminUser\VO\Username;
use InvalidArgumentException;

final class AdminUserCheckService
{
    /** 
     * @throws AdminUserNotActiveException
     * @throws InvalidPasswordException
     * @throws InvalidArgumentException
     */
    public function checkPassword(CheckPassword $command): Identifier
    {
        $username = new Username($command->username);
        $password = new Password($command->password);
        return new Identifier(1);
    }
}