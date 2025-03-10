<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\User\UserCheck;

use Romchik38\Site2\Domain\User\NoSuchUserException;

final class UserCheckService
{
    /** 
     * @throws \InvalidPasswordException 
     * @throws NoSuchUserException
     * */
    public function checkPassword(CheckPassword $command): string
    {
        return 'password is correct';
    }
}
