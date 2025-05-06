<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\AdminUser;

use InvalidArgumentException;
use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Exceptions\NoSuchAdminUserException;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Exceptions\RepositoryException;
use Romchik38\Site2\Application\AdminUser\AdminUserService\RepositoryInterface;
use Romchik38\Site2\Domain\AdminRole\VO\Description;
use Romchik38\Site2\Domain\AdminRole\VO\Identifier as RoleId;
use Romchik38\Site2\Domain\AdminRole\VO\Name;
use Romchik38\Site2\Domain\AdminUser\AdminUser;
use Romchik38\Site2\Domain\AdminUser\Entities\Role;
use Romchik38\Site2\Domain\AdminUser\VO\Email;
use Romchik38\Site2\Domain\AdminUser\VO\Identifier;
use Romchik38\Site2\Domain\AdminUser\VO\PasswordHash;
use Romchik38\Site2\Domain\AdminUser\VO\Username;

use function count;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function findByUsername(Username $username): AdminUser
    {
        $query  = $this->getByNameQuery();
        $params = [$username()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        if (count($rows) === 0) {
            throw new NoSuchAdminUserException(sprintf(
                'Admin user with username %s not exist',
                $username()
            ));
        } elseif (count($rows) > 1) {
            throw new RepositoryException(sprintf(
                'Admim user %s has duplicates',
                $username()
            ));
        } else {
            return $this->createFromRow($rows[0], $username);
        }
    }

    /**
     * @throws RepositoryException
     * @param array<string,string> $row
     */
    private function createFromRow(array $row, Username $username): AdminUser
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Admin user identifier is invalid');
        }
        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Admin user active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }
        $rawPasswordHash = $row['password_hash'] ?? null;
        if ($rawPasswordHash === null) {
            throw new RepositoryException('Admin user password hash is invalid');
        }
        $rawEmail = $row['email'] ?? null;
        if ($rawEmail === null) {
            throw new RepositoryException('Admin user email is invalid');
        }

        $roles = $this->createRoles($rawIdentifier);

        try {
            $id           = Identifier::fromString($rawIdentifier);
            $passwordHash = new PasswordHash($rawPasswordHash);
            $email        = new Email($rawEmail);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }
        return AdminUser::load(
            $id,
            $username,
            $passwordHash,
            $active,
            $email,
            $roles
        );
    }

    /**
     * @throws RepositoryException
     * @return array<int,Role> - A list of Roles or empty array.
     * */
    private function createRoles(string $rawAdminUserId): array
    {
        $roles = [];

        $query  = $this->getRolesQuery();
        $params = [$rawAdminUserId];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        foreach ($rows as $row) {
            $rawIdentifier = $row['identifier'] ?? null;
            if ($rawIdentifier === null) {
                throw new RepositoryException('Admin user role identifier is invalid');
            }
            $rawName = $row['name'] ?? null;
            if ($rawName === null) {
                throw new RepositoryException('Admin user role name is invalid');
            }
            $rawDescription = $row['description'] ?? null;
            if ($rawDescription === null) {
                throw new RepositoryException('Admin user role description is invalid');
            }
            try {
                $name        = new Name($rawName);
                $description = new Description($rawDescription);
                $identifier  = RoleId::fromString($rawIdentifier);
                $role        = new Role($identifier, $name, $description);
                $roles[]     = $role;
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
        }
        return $roles;
    }

    private function getByNameQuery(): string
    {
        return <<<'QUERY'
        SELECT admin_users.identifier,
            admin_users.username,
            admin_users.password_hash,
            admin_users.active,
            admin_users.email
        FROM admin_users
        WHERE admin_users.username = $1
        QUERY;
    }

    private function getRolesQuery(): string
    {
        return <<<'QUERY'
        SELECT admin_roles.identifier,
            admin_roles.name,
            admin_roles.description
        FROM admin_roles, admin_users_with_roles
        WHERE admin_roles.identifier = admin_users_with_roles.role_id
            AND admin_users_with_roles.user_id = $1
        QUERY;
    }
}
