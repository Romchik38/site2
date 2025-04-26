<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser;

use InvalidArgumentException;
use Romchik38\Site2\Domain\AdminUser\Entities\Role;
use Romchik38\Site2\Domain\AdminUser\VO\Email;
use Romchik38\Site2\Domain\AdminUser\VO\Identifier;
use Romchik38\Site2\Domain\AdminUser\VO\Password;
use Romchik38\Site2\Domain\AdminUser\VO\PasswordHash;
use Romchik38\Site2\Domain\AdminUser\VO\Username;

use function array_values;
use function password_verify;

/** @todo tests */
final class AdminUser
{
    /** @var array<string,Role>*/
    private array $roles = [];

    /** @param array<int,mixed|Role> $roles*/
    private function __construct(
        private ?Identifier $identifier,
        private Username $username,
        private PasswordHash $passwordHash,
        private bool $active,
        private Email $email,
        array $roles
    ) {
        foreach ($roles as $role) {
            if (! $role instanceof Role) {
                throw new InvalidArgumentException('param admin user role is invalid');
            }
            $roleName                 = $role->getName();
            $this->roles[$roleName()] = $role;
        }
    }

    public function checkPassword(Password $password): bool
    {
        return password_verify($password(), ($this->passwordHash)());
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getId(): ?Identifier
    {
        return $this->identifier;
    }

    public function getRole(string $roleName): ?Role
    {
        return $this->roles[$roleName] ?? null;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    /** @return array<int,Role> */
    public function getRoles(): array
    {
        return array_values($this->roles);
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function hasRole(string $roleName): bool
    {
        $role = $this->roles[$roleName] ?? null;
        if ($role === null) {
            return false;
        }
        return true;
    }

    /**
     * @param array<int,Role> $roles
     * @throws InvalidArgumentException
     * */
    public static function create(
        Username $username,
        PasswordHash $passwordHash,
        Email $email,
        array $roles = []
    ): self {
        return new self(
            null,
            $username,
            $passwordHash,
            false,
            $email,
            $roles
        );
    }

    /**
     * @param array<int,Role> $roles
     * @throws InvalidArgumentException
     * */
    public static function load(
        Identifier $id,
        Username $username,
        PasswordHash $passwordHash,
        bool $active,
        Email $email,
        array $roles
    ): self {
        return new self(
            $id,
            $username,
            $passwordHash,
            $active,
            $email,
            $roles
        );
    }
}
