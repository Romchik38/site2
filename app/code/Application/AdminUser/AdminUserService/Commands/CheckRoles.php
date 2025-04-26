<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\AdminUser\AdminUserService\Commands;

final class CheckRoles
{
    public const FIRST_MATCH = 'first_match';
    public const ALL         = 'all';

    /** @param array<int,string>  $roles */
    private function __construct(
        public readonly string $method,
        public readonly array $roles,
        public readonly string $username
    ) {
    }

    /** @param array<int,string>  $roles */
    public static function firstMatch(array $roles, string $username): self
    {
        return new self(self::FIRST_MATCH, $roles, $username);
    }

    /** @param array<int,string>  $roles */
    public static function all(array $roles, string $username): self
    {
        return new self(self::ALL, $roles, $username);
    }
}
