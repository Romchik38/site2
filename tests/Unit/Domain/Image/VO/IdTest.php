<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Image\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Image\VO\Id;

use function sprintf;

final class IdTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = '1';
        $id    = Id::fromString($value);
        $this->assertSame(1, $id());
    }

    public function testToString(): void
    {
        $value = '1';
        $id    = Id::fromString($value);
        $this->assertSame($value, (string) $id);
    }

    public function testFromStringThrowsErrorOnWrongValue(): void
    {
        $value = '5s';
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s %s is invalid', Id::NAME, $value));
        Id::fromString($value);
    }

    public function testConstructThrowsErrorOnZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s must be greater than 0', Id::NAME));
        new Id(0);
    }

    public function testConstructThrowsErrorOnNegative(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s must be greater than 0', Id::NAME));
        new Id(-10);
    }
}
