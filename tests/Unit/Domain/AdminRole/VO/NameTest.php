<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\AdminRole\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\AdminRole\VO\Name;

use function sprintf;

final class NameTest extends TestCase
{
    public function testInvoke(): void
    {
        $name = new Name('ADMIN_ROOT');
        $this->assertSame('ADMIN_ROOT', $name());
    }

    public function testToString(): void
    {
        $name = new Name('ADMIN_ROOT');
        $this->assertSame('ADMIN_ROOT', (string) $name);
    }

    public function testConstructThrowsErrorNameInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            Name::ERROR_ROLE_NAME_INVALID,
            'wrong_name'
        ));

        new Name('wrong_name');
    }
}
