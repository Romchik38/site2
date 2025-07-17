<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\AdminUser\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\AdminUser\VO\Username;

final class UsernameTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = 'Some_login1';
        $e     = new Username($value);

        $this->assertSame($value, $e());
    }

    public function testToString(): void
    {
        $value = 'Some_login';
        $e     = new Username($value);

        $this->assertSame($value, (string) $e);
    }

    public function testConstructThrowsErrorOnEmpty(): void
    {
        $value = '';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Username::ERROR_MESSAGE);

        new Username($value);
    }

    public function testConstructThrowsErrorOnWrongPatternSpace(): void
    {
        $value = 'Some login';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Username::ERROR_MESSAGE);

        new Username($value);
    }

    public function testConstructThrowsErrorOnWrongPatternDot(): void
    {
        $value = 'Some.login';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Username::ERROR_MESSAGE);

        new Username($value);
    }

    public function testConstructThrowsErrorOnWrongPatternTooShort(): void
    {
        $value = 'So';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Username::ERROR_MESSAGE);

        new Username($value);
    }

    public function testConstructThrowsErrorOnWrongPatternTooLong(): void
    {
        $value = 'So_asdfasdfasdfasdfadsfasdfadfadsfasdfasdf';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Username::ERROR_MESSAGE);

        new Username($value);
    }
}
