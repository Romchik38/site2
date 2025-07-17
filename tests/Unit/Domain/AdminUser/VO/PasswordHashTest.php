<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\AdminRole\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\AdminUser\VO\PasswordHash;

final class PasswordHashTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = 'some_hash';
        $d     = new PasswordHash($value);
        $this->assertSame($value, $d());
    }

    public function testToString(): void
    {
        $value = 'some_hash';
        $d     = new PasswordHash($value);
        $this->assertSame($value, (string) $d);
    }

    public function testConstructThrowsErrorOnEmptyPasswordHash(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param Admin user password hash is empty');
        new PasswordHash('');
    }
}
