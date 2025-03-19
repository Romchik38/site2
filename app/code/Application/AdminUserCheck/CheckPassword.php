<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\AdminUserCheck;

use Romchik38\Site2\Domain\AdminUser\VO\Password;
use Romchik38\Site2\Domain\AdminUser\VO\Username;

final class CheckPassword
{
    public function __construct(
        public readonly string $username,
        public readonly string $password,
    ) {
    }

    /** @param array<string,string> $hash */
    public static function fromHash(array $hash): self
    {
        return new self(
            $hash[Username::FIELD] ?? '',
            $hash[Password::FIELD] ?? '',
        );
    }
}
