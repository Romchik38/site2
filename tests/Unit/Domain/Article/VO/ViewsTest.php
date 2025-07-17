<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\AdminRole\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Article\VO\Views;

use function sprintf;

final class ViewsTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = '1';
        $id    = Views::fromString($value);
        $this->assertSame(1, $id());
    }

    public function testToString(): void
    {
        $value = '1';
        $id    = Views::fromString($value);
        $this->assertSame($value, (string) $id);
    }

    public function testFromStringThrowsErrorOnWrongValue(): void
    {
        $value = '1.1';
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s 1.1 is invalid', Views::NAME));
        Views::fromString($value);
    }

    public function testConstructThrowsErrorOnNegative(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s is less than 0', Views::NAME));
        new Views(-10);
    }
}
