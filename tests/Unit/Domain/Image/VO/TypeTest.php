<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Image\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Image\VO\Type;

use function sprintf;

final class TypeTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = 'webp';
        $vo    = new Type($value);
        $this->assertSame($value, $vo());
    }

    public function testToString(): void
    {
        $value = 'webp';
        $vo    = new Type($value);
        $this->assertSame($value, (string) $vo);
    }

    public function testConstructThrowsErrorOnWrongType(): void
    {
        $value = 'wrong_type';
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s %s is invalid', Type::NAME, $value));
        new Type($value);
    }
}
