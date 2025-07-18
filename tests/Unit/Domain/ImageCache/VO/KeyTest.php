<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\ImageCache\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\ImageCache\VO\Key;

use function sprintf;

final class KeyTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = 'id-10-size-20-width-30';
        $vo    = new Key($value);
        $this->assertSame($value, $vo());
    }

    public function testToString(): void
    {
        $value = 'id-10-size-20-width-30';
        $vo    = new Key($value);
        $this->assertSame($value, (string) $vo);
    }

    public function testConstructThrowsErrorOnEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s is empty', Key::NAME));
        new Key('');
    }
}
