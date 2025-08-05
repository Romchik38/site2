<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\User\UserCheck;

final class CheckPassword
{
    public const EMAIL_FIELD    = 'email';
    public const PASSWORD_FIELD = 'password';

    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {
    }

    /** @param array<string,string> $hash */
    public static function fromHash(array $hash): self
    {
        return new self(
            $hash[self::EMAIL_FIELD] ?? '',
            $hash[self::PASSWORD_FIELD] ?? '',
        );
    }
}
