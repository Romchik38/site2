<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\AdminUser\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\AdminUser\VO\Identifier;

final class IdentifierTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = '1';
        $id    = Identifier::fromString($value);
        $this->assertSame(1, $id());
    }

    public function testToString(): void
    {
        $value = '1';
        $id    = Identifier::fromString($value);
        $this->assertSame($value, (string) $id);
    }

    public function testFromStringThrowsErrorOnWrongValue(): void
    {
        $value = '5s';
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param Admin user id 5s is invalid');
        Identifier::fromString($value);
    }

    public function testConstructThrowsErrorOnZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param Admin user id must be greater than 0');
        new Identifier(0);
    }

    public function testConstructThrowsErrorOnNegative(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param Admin user id must be greater than 0');
        new Identifier(-10);
    }
}
