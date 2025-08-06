<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\User\UserCheck;

use InvalidArgumentException;
use Romchik38\Site2\Domain\User\NoSuchUserException;
use Romchik38\Site2\Domain\User\VO\Email;
use Romchik38\Site2\Domain\User\VO\Password;
use Romchik38\Site2\Domain\User\VO\Username;

use function random_int;
use function sprintf;

final class UserCheckService
{
    /**
     * @throws InvalidPasswordException
     * @throws NoSuchUserException
     * @throws InvalidArgumentException
     * */
    public function checkPassword(CheckPassword $command): Username
    {
        $password = new Password($command->password);
        $email    = new Email($command->email);

        if ($email() === 'hello@world') {
            throw new NoSuchUserException(sprintf('user with email %s not found', $email()));
        }

        $rand = random_int(1, 10);
        if ($rand === 7) {
            throw new InvalidPasswordException('Invalid password, try again');
        }

        return new Username('user - ' . $rand);
    }
}
