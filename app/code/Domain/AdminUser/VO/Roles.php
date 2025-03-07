<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser\VO;

use InvalidArgumentException;
use Romchik38\Site2\Domain\AdminRole\VO\Name;

final class Roles
{
    /** @var array<string, Name> */
    protected array $hash;

    /** @param array<int,Role> $roles*/
    public function __construct(
        array $roles
    )
    {
        if (count($roles) === 0) {
            throw new InvalidArgumentException('Roles list is empty');
        }
        foreach($roles as $role) {
            $roleName = $role->name();
            $this->hash[$roleName()] = $role;
        }
    }

    public function hasRole(string $roleName): bool
    {
        $role = $this->hash[$roleName] ?? null;
        if ($role === null) {
            return false;
        }
        return true;
    }
}