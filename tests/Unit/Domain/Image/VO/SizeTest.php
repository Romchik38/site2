<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Image\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Image\VO\Size;

use function sprintf;

final class SizeTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = '1000';
        $id    = Size::fromString($value);
        $this->assertSame(1000, $id());
    }

    public function testToString(): void
    {
        $value = '1000';
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

    public function testConstructThrowsErrorTooBig(): void
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
