<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\AdminUserRoles;

final class ListRoles
{
    public function __construct(
        public readonly string $username
    ) {
    }
}
