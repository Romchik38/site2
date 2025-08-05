<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\AdminUser\AdminUserService\Commands;

final class CheckPassword
{
    public const PASSWORD_FIELD = 'password';
    public const USERNAME_FIELD = 'user_name';

    public function __construct(
        public readonly string $username,
        public readonly string $password,
    ) {
    }

    /** @param array<string,string> $hash */
    public static function fromHash(array $hash): self
    {
        return new self(
            $hash[self::USERNAME_FIELD] ?? '',
            $hash[self::PASSWORD_FIELD] ?? '',
        );
    }
}
