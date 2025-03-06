<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\AdminUser;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Site2\Domain\AdminUser\AdminUser;
use Romchik38\Site2\Domain\AdminUser\AdminUserInterface;
use Romchik38\Site2\Domain\AdminUser\AdminUserRepositoryInreface;
use Romchik38\Site2\Domain\AdminUser\NoSuchAdminUserException;
use Romchik38\Site2\Domain\AdminUser\VO\Active;
use Romchik38\Site2\Domain\AdminUser\VO\Email;
use Romchik38\Site2\Domain\AdminUser\VO\Identifier;
use Romchik38\Site2\Domain\AdminUser\VO\PasswordHash;
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

    /** @var array<string,AdminUserInterface> $hash */
    protected $hash = [];
    
    public function __construct(
        protected readonly DatabaseInterface $database
    )
    {
        
    }
    public function findByUsername(Username $username): AdminUserInterface
    {
        /** 1 check the hash */
        $hashed = $this->hash[$username()] ?? null;
        if ($hashed !== null) {
            return $hashed;
        }

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
        $admin_user = $this->createSingleAdminUserFromRows($rows);

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
        // 1. create translates
        $roles = $this->createRolesFromRows($rows);

        // 2. create an entity
        $firstRow = $rows[0];
        $entity = new AdminUser(
            new Identifier((int) $firstRow[$this::ADMIN_USER_C_IDENTIFIER]),
            new Username($firstRow[$this::ADMIN_USER_C_USERNAME]),
            new PasswordHash($firstRow[$this::ADMIN_USER_C_PASSWORD_HASH]),
            new Active($firstRow[$this::ADMIN_USER_C_ACTIVE] === 'f' ? false : true),
            new Email($firstRow[$this::ADMIN_USER_C_EMAIL])
            $roles
        );

        return $entity;
    }
}