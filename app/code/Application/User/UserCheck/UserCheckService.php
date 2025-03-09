<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\User\UserCheck;

final class UserCheckService
{
    /** @throws InvalidPasswordException */
    public function checkPassword(CheckPassword $command): string
    {
        return 'password is correct';
    }
}
