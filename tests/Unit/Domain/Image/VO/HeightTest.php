<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Image\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Image\VO\Height;

use function sprintf;

final class HeightTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = '1085';
        $id    = Height::fromString($value);
        $this->assertSame(1085, $id());
    }

    public function testToString(): void
    {
        $value = '1085';
        $id    = Height::fromString($value);
        $this->assertSame($value, (string) $id);
    }

    public function testFromStringThrowsErrorOnWrongValue(): void
    {
        $value = '5s';
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s %s is invalid', Height::NAME, $value));
        Height::fromString($value);
    }

    public function testConstructThrowsErrorTooMin(): void
    {
        $value = Height::MIN_VALUE - 1;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            'param %s %d is too small, min is %d',
            Height::NAME,
            $value,
            Height::MIN_VALUE
        ));
        new Height($value);
    }
}
