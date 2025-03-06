<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser;

use Romchik38\Site2\Domain\AdminUser\VO\Active;
use Romchik38\Site2\Domain\AdminUser\VO\Email;
use Romchik38\Site2\Domain\AdminUser\VO\Identifier;
use Romchik38\Site2\Domain\AdminUser\VO\PasswordHash;
use Romchik38\Site2\Domain\AdminUser\VO\Username;

final class AdminUser implements AdminUserInterface
{
    public function __construct(
        protected Identifier $identifier,
        protected Username $username,
        protected PasswordHash $passwordHash,
        protected Active $active,
        protected Email $email
    ){
    }
}