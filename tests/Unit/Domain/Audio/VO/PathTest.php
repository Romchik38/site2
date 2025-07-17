<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Audio\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Audio\VO\Path;

use function sprintf;

final class PathTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = 'some Name';
        $d     = new Path($value);
        $this->assertSame($value, $d());
    }

    public function testToString(): void
    {
        $value = 'some Name';
        $d     = new Path($value);
        $this->assertSame($value, (string) $d);
    }

    public function testConstructThrowsErrorOnEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s is empty', Path::NAME));
        new Path('');
    }
}
