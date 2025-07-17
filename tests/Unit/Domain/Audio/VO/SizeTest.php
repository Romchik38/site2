<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Audio\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Audio\VO\Size;

use function sprintf;

final class SizeTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = '1';
        $id    = Size::fromString($value);
        $this->assertSame(1, $id());
    }

    public function testToString(): void
    {
        $value = '1';
        $id    = Size::fromString($value);
        $this->assertSame($value, (string) $id);
    }

    public function testFromStringThrowsErrorOnWrongValue(): void
    {
        $value = '5s';
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s %s is invalid', Size::NAME, $value));
        Size::fromString($value);
    }

    public function testConstructThrowsErrorOnZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s must be greater than 0', Size::NAME));
        new Size(0);
    }

    public function testConstructThrowsErrorOnNegative(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s must be greater than 0', Size::NAME));
        new Size(-10);
    }

    public function testConstructThrowsErrorOnTooBig(): void
    {
        $value = Size::MAX_VALUE + 1;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            'param %s %d is too big, max is %d',
            Size::NAME,
            $value,
            Size::MAX_VALUE
        ));

        new Size($value);
    }
}
