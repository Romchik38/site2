<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\AdminUser;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Site2\Domain\AdminRole\VO\Description;
use Romchik38\Site2\Domain\AdminRole\VO\Identifier as VOIdentifier;
use Romchik38\Site2\Domain\AdminRole\VO\Name;
use Romchik38\Site2\Domain\AdminUser\AdminUser;
use Romchik38\Site2\Domain\AdminUser\AdminUserInterface;
use Romchik38\Site2\Domain\AdminUser\AdminUserRepositoryInreface;
use Romchik38\Site2\Domain\AdminUser\NoSuchAdminUserException;
use Romchik38\Site2\Domain\AdminUser\VO\Active;
use Romchik38\Site2\Domain\AdminUser\VO\Email;
use Romchik38\Site2\Domain\AdminUser\VO\Identifier;
use Romchik38\Site2\Domain\AdminUser\VO\PasswordHash;
use Romchik38\Site2\Domain\AdminUser\VO\Role;
use Romchik38\Site2\Domain\AdminUser\VO\Roles;
use Romchik38\Site2\Domain\AdminUser\VO\Username;

final class AdminUserRepository implements AdminUserRepositoryInreface
{
    /** admin_users */
    final const ADMIN_USER_T = 'admin_users';
    final const ADMIN_USER_C_IDENTIFIER = 'identifier';
    final const ADMIN_USER_C_USERNAME = 'username';
    final const ADMIN_USER_C_PASSWORD_HASH = 'password_hash';    
    final const ADMIN_USER_C_ACTIVE = 'active';
    final const ADMIN_USER_C_EMAIL = 'email';

    /** admin_users_with_roles */
    final const ADMIN_ROLES_T = 'admin_roles';
    final const ADMIN_ROLES_C_IDENTIFIER = 'identifier';
    final const ADMIN_ROLES_C_NAME = 'name';
    final const ADMIN_ROLES_C_DESCRIPTION = 'description';
    
    public function __construct(
        protected readonly DatabaseInterface $database
    )
    {
        
    }
    public function findByUsername(Username $username): AdminUserInterface
    {
        $expression = sprintf(
            'WHERE %s.%s = $1',
            $this::ADMIN_USER_T,
            $this::ADMIN_USER_C_IDENTIFIER
        );

        /** 2. Entity rows */
        $rows = $this->listRows(
            [sprintf('%s.*', $this::ADMIN_USER_T)],
            [$this::ADMIN_USER_T],
            $expression,
            [$username()]
        );

        if (count($rows) === 0) {
            throw new NoSuchAdminUserException(
                sprintf('Admin user with username %s not exist', $username())
            );
        }

        /** 3. Create an Entity */
        return $this->createSingleAdminUserFromRows($rows);
    }

     /**
     * SELECT
     * used to select rows from all tables by given expression
     * @param string[] $params
     * @param string[] $selectedFields
     * @param string[] $selectedTables
     * @return array<int,array<string,string>>
     */
    protected function listRows(
        array $selectedFields,
        array $selectedTables,
        string $expression,
        array $params
    ): array {

        $query = 'SELECT ' . implode(', ', $selectedFields)
            . ' FROM ' . implode(', ', $selectedTables) . ' ' . $expression;

        $rows = $this->database->queryParams($query, $params);

        return $rows;
    }

    /**
     * Create an AdminUser entity from rows with the same username
     * @param array<int,array<string,string>> $rows
     */
    protected function createSingleAdminUserFromRows(array $rows): AdminUserInterface
    {
        // 1. create roles
        $roles = $this->createRolesFromRows($rows);

        // 2. create an entity
        $firstRow = $rows[0];
        $entity = new AdminUser(
            new Identifier((int) $firstRow[$this::ADMIN_USER_C_IDENTIFIER]),
            new Username($firstRow[$this::ADMIN_USER_C_USERNAME]),
            new PasswordHash($firstRow[$this::ADMIN_USER_C_PASSWORD_HASH]),
            new Active($firstRow[$this::ADMIN_USER_C_ACTIVE] === 'f' ? false : true),
            new Email($firstRow[$this::ADMIN_USER_C_EMAIL]),
            new Roles($roles)
        );

        return $entity;
    }

    /**
     * Create all roles for AdminUser
     * 
     * @param array<int,array<string,string>> $AdminUser rows of a single model, all admin user ids must be the same
     * @return array<int,Roles> - A list of Roles or empty array 
     * */
    protected function createRolesFromRows(array $adminUserRows): array
    {
        $roles = [];
        if (count($adminUserRows) === 0) {
            return $roles;
        }

        $firstRow = $adminUserRows[0];
        $adminUserId = $firstRow[$this::ADMIN_USER_C_IDENTIFIER] ?? null;
        if ($adminUserId === null) {
            return $roles;
        }

        $expression = <<<SQL
        SELECT admin_roles.identifier,
            admin_roles.name,
            admin_roles.description
        FROM admin_roles, admin_users_with_roles
        WHERE admin_roles.identifier = admin_users_with_roles.role_id
            AND admin_users_with_roles.user_id = $1
        SQL;

        $rows = $this->database->queryParams($expression,[$adminUserId]);

        foreach ($rows as $row) {
            $name = new Name($row[$this::ADMIN_ROLES_C_NAME]);
            $description = new Description($row[$this::ADMIN_ROLES_C_DESCRIPTION]);
            $identifier = new VOIdentifier((int) $row[$this::ADMIN_ROLES_C_IDENTIFIER]);
            $role = new Role($identifier, $name, $description);
            $roles[] = $role;
        }
        return $roles;
    }
}