<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Image\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Image\VO\Width;

use function sprintf;

final class WidthTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = '1085';
        $id    = Width::fromString($value);
        $this->assertSame(1085, $id());
    }

    public function testToString(): void
    {
        $value = '1085';
        $id    = Width::fromString($value);
        $this->assertSame($value, (string) $id);
    }

    public function testFromStringThrowsErrorOnWrongValue(): void
    {
        $value = '5s';
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s %s is invalid', Width::NAME, $value));
        Width::fromString($value);
    }

    public function testConstructThrowsErrorTooMin(): void
    {
        $value = Width::MIN_VALUE - 1;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            'param %s %d is too small, min is %d',
            Width::NAME,
            $value,
            Width::MIN_VALUE
        ));
        new Width($value);
    }
}
