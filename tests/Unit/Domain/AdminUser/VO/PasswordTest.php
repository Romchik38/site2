<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\AdminUser\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\AdminUser\VO\Password;

final class PasswordTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = 'As1_qwE*';
        $e     = new Password($value);

        $this->assertSame($value, $e());
    }

    public function testToString(): void
    {
        $value = 'As1_qwE*';
        $e     = new Password($value);

        $this->assertSame($value, (string) $e);
    }

    public function testConstructThrowsErrorOnEmpty(): void
    {
        $value = '';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Password::ERROR_MESSAGE);

        new Password($value);
    }

    public function testConstructThrowsErrorOnWrongPattern(): void
    {
        $value = 'some1mail';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Password::ERROR_MESSAGE);

        new Password($value);
    }

    public function testConstructThrowsErrorOnWrongPattern2(): void
    {
        $value = 'As1_qwE';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Password::ERROR_MESSAGE);

        new Password($value);
    }

    public function testConstructThrowsErrorOnWrongPattern3(): void
    {
        $value = 'As1_qwE*&';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Password::ERROR_MESSAGE);

        new Password($value);
    }
}
