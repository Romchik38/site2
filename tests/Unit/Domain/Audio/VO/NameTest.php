<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Audio\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Audio\VO\Name;

use function sprintf;

final class NameTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = 'some Name';
        $d     = new Name($value);
        $this->assertSame($value, $d());
    }

    public function testToString(): void
    {
        $value = 'some Name';
        $d     = new Name($value);
        $this->assertSame($value, (string) $d);
    }

    public function testConstructThrowsErrorOnEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s is empty', Name::NAME));
        new Name('');
    }
}
