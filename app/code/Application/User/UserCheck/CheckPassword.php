<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\User\UserCheck;

final class CheckPassword
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {
    }

    public static function fromHash(array $hash): self
    {
        return new self(
            $hash['email'] ?? '',
            $hash['password'] ?? '',
        );
    }
}