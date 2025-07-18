<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Banner\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Banner\VO\Priority;

use function sprintf;

final class PriorityTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = '1';
        $id    = Priority::fromString($value);
        $this->assertSame(1, $id());
    }

    public function testToString(): void
    {
        $value = '1';
        $id    = Priority::fromString($value);
        $this->assertSame($value, (string) $id);
    }

    public function testFromStringThrowsErrorOnWrongValue(): void
    {
        $value = '5s';
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s %s is invalid', Priority::NAME, $value));
        Priority::fromString($value);
    }

    public function testConstructThrowsErrorTooMin(): void
    {
        $value = Priority::MIN_PRIORITY - 1;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Param %s %d is invalid', Priority::NAME, $value));
        new Priority($value);
    }

    public function testConstructThrowsErrorTooBig(): void
    {
        $value = Priority::MAX_PRIORITY + 1;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Param %s %d is invalid', Priority::NAME, $value));
        new Priority($value);
    }
}
