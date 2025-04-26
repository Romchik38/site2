<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\AdminUser;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\AdminRole\VO\Description as RoleDescription;
use Romchik38\Site2\Domain\AdminRole\VO\Identifier as RoleId;
use Romchik38\Site2\Domain\AdminRole\VO\Name as RoleName;
use Romchik38\Site2\Domain\AdminUser\AdminUser;
use Romchik38\Site2\Domain\AdminUser\Entities\Role;
use Romchik38\Site2\Domain\AdminUser\Exceptions\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\AdminUser\VO\Email;
use Romchik38\Site2\Domain\AdminUser\VO\Identifier;
use Romchik38\Site2\Domain\AdminUser\VO\Password;
use Romchik38\Site2\Domain\AdminUser\VO\PasswordHash;
use Romchik38\Site2\Domain\AdminUser\VO\Username;
use stdClass;

final class AdminUserTests extends TestCase
{
    /**
     * Tested:
     *   - create
     *   - isActive (false on create)
     *   - getEmail
     *   - getId (null)
     *   - getPasswordHash
     *   - getUsername
     */
    public function testCreate(): void
    {
        $username     = new Username('some_user_name');
        $email        = new Email('some@example.com');
        $passwordHash = new PasswordHash('$2y$12$rr2AhYjrTU7RBnvtlw2BxOa9LhK/30VYQTzwuTOYc1f0M2OqrOzy.'); // 123

        $adminUser = AdminUser::create(
            $username,
            $passwordHash,
            $email
        );

        $this->assertSame(null, $adminUser->getId());
        $this->assertSame($username, $adminUser->getUsername());
        $this->assertSame($email, $adminUser->getEmail());
        $this->assertSame($passwordHash, $adminUser->getPasswordHash());
        $this->assertSame(false, $adminUser->isActive());
    }

    public function testCreateThrowErrorOnWrongRoles(): void
    {
        $username     = new Username('some_user_name');
        $email        = new Email('some@example.com');
        $passwordHash = new PasswordHash('$2y$12$rr2AhYjrTU7RBnvtlw2BxOa9LhK/30VYQTzwuTOYc1f0M2OqrOzy.'); // 123

        $role1 = new stdClass(); // wrong
        $roles = [$role1];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(AdminUser::ERROR_INVALID_ROLE);

        AdminUser::create(
            $username,
            $passwordHash,
            $email,
            $roles
        );
    }

    /**
     * Tested:
     *   - load
     *   - getId (not null)
     *   - isActive (true)
     */
    public function testLoad(): void
    {
        $id           = new Identifier(1);
        $username     = new Username('some_user_name');
        $email        = new Email('some@example.com');
        $passwordHash = new PasswordHash('$2y$12$rr2AhYjrTU7RBnvtlw2BxOa9LhK/30VYQTzwuTOYc1f0M2OqrOzy.'); // 123

        $role1 = new Role(
            new RoleId(1),
            new RoleName('ADMIN_ROOT'),
            new RoleDescription('role description 1')
        );
        $roles = [$role1];

        $adminUser = AdminUser::load(
            $id,
            $username,
            $passwordHash,
            true,
            $email,
            $roles
        );

        $this->assertSame($id, $adminUser->getId());
        $this->assertSame(true, $adminUser->isActive());
    }

    public function testLoadThrowsErrorOnWrongRole(): void
    {
        $id           = new Identifier(1);
        $username     = new Username('some_user_name');
        $email        = new Email('some@example.com');
        $passwordHash = new PasswordHash('$2y$12$rr2AhYjrTU7RBnvtlw2BxOa9LhK/30VYQTzwuTOYc1f0M2OqrOzy.'); // 123

        $role1 = new stdClass();
        $roles = [$role1];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(AdminUser::ERROR_INVALID_ROLE);

        AdminUser::load(
            $id,
            $username,
            $passwordHash,
            true,
            $email,
            $roles
        );
    }

    public function testCheckPassword(): void
    {
        $id           = new Identifier(1);
        $username     = new Username('some_user_name');
        $email        = new Email('some@example.com');
        $passwordHash = new PasswordHash('$2y$12$wDa52DVanPJKEWsPbwnFleLZDB91W7TAHTEQC880nR.M9QTHA9mDa'); // pas1W$yes
        $password     = new Password('pas1W$yes');

        $role1 = new Role(
            new RoleId(1),
            new RoleName('ADMIN_ROOT'),
            new RoleDescription('role description 1')
        );
        $roles = [$role1];

        $adminUser = AdminUser::load(
            $id,
            $username,
            $passwordHash,
            true,
            $email,
            $roles
        );

        $this->assertSame(true, $adminUser->checkPassword($password));
    }

    public function testCheckPasswordWrongPassword(): void
    {
        $id           = new Identifier(1);
        $username     = new Username('some_user_name');
        $email        = new Email('some@example.com');
        $passwordHash = new PasswordHash('$2y$12$wDa52DVanPJKEWsPbwnFleLZDB91W7TAHTEQC880nR.M9QTHA9mDa'); // pas1W$yes
        $password     = new Password('wrong_pas1W$yes');

        $role1 = new Role(
            new RoleId(1),
            new RoleName('ADMIN_ROOT'),
            new RoleDescription('role description 1')
        );
        $roles = [$role1];

        $adminUser = AdminUser::load(
            $id,
            $username,
            $passwordHash,
            true,
            $email,
            $roles
        );

        $this->assertSame(false, $adminUser->checkPassword($password));
    }

    /**
     * Tested:
     *   - getRole
     *   - getRoles
     *   - hasRole
     */
    public function testGetRole(): void
    {
        $id           = new Identifier(1);
        $username     = new Username('some_user_name');
        $email        = new Email('some@example.com');
        $passwordHash = new PasswordHash('$2y$12$wDa52DVanPJKEWsPbwnFleLZDB91W7TAHTEQC880nR.M9QTHA9mDa'); // pas1W$yes

        $role1 = new Role(
            new RoleId(1),
            new RoleName('ADMIN_ROOT'),
            new RoleDescription('role description 1')
        );
        $roles = [$role1];

        $adminUser = AdminUser::load(
            $id,
            $username,
            $passwordHash,
            true,
            $email,
            $roles
        );

        $this->assertSame($role1, $adminUser->getRole('ADMIN_ROOT'));
        $this->assertSame(true, $adminUser->hasRole('ADMIN_ROOT'));
        $this->assertSame(false, $adminUser->hasRole('not_exist_role'));
        $this->assertSame($roles, $adminUser->getRoles());
    }

    public function testActivate(): void
    {
        $id           = new Identifier(1);
        $username     = new Username('some_user_name');
        $email        = new Email('some@example.com');
        $passwordHash = new PasswordHash('$2y$12$wDa52DVanPJKEWsPbwnFleLZDB91W7TAHTEQC880nR.M9QTHA9mDa'); // pas1W$yes

        $role1 = new Role(
            new RoleId(1),
            new RoleName('ADMIN_ROOT'),
            new RoleDescription('role description 1')
        );
        $roles = [$role1];

        $adminUser = AdminUser::load(
            $id,
            $username,
            $passwordHash,
            false,
            $email,
            $roles
        );

        $this->assertSame(false, $adminUser->isActive());
        $adminUser->activate();
        $this->assertSame(true, $adminUser->isActive());
    }

    public function testActivateThrowsErrorIdNotSet(): void
    {
        $username     = new Username('some_user_name');
        $email        = new Email('some@example.com');
        $passwordHash = new PasswordHash('$2y$12$rr2AhYjrTU7RBnvtlw2BxOa9LhK/30VYQTzwuTOYc1f0M2OqrOzy.'); // 123

        $adminUser = AdminUser::create(
            $username,
            $passwordHash,
            $email
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage(AdminUser::ERROR_ID_NOT_SET);

        $adminUser->activate();
    }

    public function testActivateThrowsErrorNoRoles(): void
    {
        $id           = new Identifier(1);
        $username     = new Username('some_user_name');
        $email        = new Email('some@example.com');
        $passwordHash = new PasswordHash('$2y$12$wDa52DVanPJKEWsPbwnFleLZDB91W7TAHTEQC880nR.M9QTHA9mDa'); // pas1W$yes

        $roles = [];

        $adminUser = AdminUser::load(
            $id,
            $username,
            $passwordHash,
            false,
            $email,
            $roles
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage(AdminUser::ERROR_NO_ROLES);

        $adminUser->activate();
    }

    public function testDeactivate(): void
    {
        $id           = new Identifier(1);
        $username     = new Username('some_user_name');
        $email        = new Email('some@example.com');
        $passwordHash = new PasswordHash('$2y$12$wDa52DVanPJKEWsPbwnFleLZDB91W7TAHTEQC880nR.M9QTHA9mDa'); // pas1W$yes

        $role1 = new Role(
            new RoleId(1),
            new RoleName('ADMIN_ROOT'),
            new RoleDescription('role description 1')
        );
        $roles = [$role1];

        $adminUser = AdminUser::load(
            $id,
            $username,
            $passwordHash,
            true,
            $email,
            $roles
        );

        $this->assertSame(true, $adminUser->isActive());
        $adminUser->deactivate();
        $this->assertSame(false, $adminUser->isActive());
    }
}
