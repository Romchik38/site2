<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\AdminUser\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\AdminUser\VO\Email;

final class EmailTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = 'some@mail.com';
        $e     = new Email($value);

        $this->assertSame($value, $e());
    }

    public function testToString(): void
    {
        $value = 'some@mail.com';
        $e     = new Email($value);

        $this->assertSame($value, (string) $e);
    }

    public function testConstructThrowsErrorOnEmpty(): void
    {
        $value = '';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Email::ERROR_MESSAGE);

        new Email($value);
    }

    public function testConstructThrowsErrorOnWrongPattern(): void
    {
        $value = 'some@mail';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Email::ERROR_MESSAGE);

        new Email($value);
    }

    public function testConstructThrowsErrorOnWrongPattern2(): void
    {
        $value = 'some@mail.';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Email::ERROR_MESSAGE);

        new Email($value);
    }

    public function testConstructThrowsErrorOnWrongPattern3(): void
    {
        $value = 'som\;e@mail.com';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Email::ERROR_MESSAGE);

        new Email($value);
    }
}
