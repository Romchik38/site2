<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser;

use Romchik38\Site2\Domain\AdminUser\VO\Email;
use Romchik38\Site2\Domain\AdminUser\VO\Identifier;
use Romchik38\Site2\Domain\AdminUser\VO\Password;
use Romchik38\Site2\Domain\AdminUser\VO\PasswordHash;
use Romchik38\Site2\Domain\AdminUser\VO\Roles;
use Romchik38\Site2\Domain\AdminUser\VO\Username;

use function password_verify;

/** @todo tests */
final class AdminUser
{
    public function __construct(
        private Identifier $identifier,
        private Username $username,
        private PasswordHash $passwordHash,
        private bool $active,
        private Email $email,
        /** @todo refactor - array of Roles */
        private Roles $roles
    ) {
    }

    public function checkPassword(Password $password): bool
    {
        return password_verify($password(), ($this->passwordHash)());
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function identifier(): Identifier
    {
        return $this->identifier;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function username(): Username
    {
        return $this->username;
    }

    /** @todo refactor */
    public function roles(): Roles
    {
        return $this->roles;
    }
}
