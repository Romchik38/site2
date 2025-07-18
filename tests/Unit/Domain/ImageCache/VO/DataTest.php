<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\ImageCache\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\ImageCache\VO\Data;

use function sprintf;

final class DataTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = '10Fdsz1asd,l;asd91';
        $vo    = new Data($value);
        $this->assertSame($value, $vo());
    }

    public function testToString(): void
    {
        $value = '10Fdsz1asd,l;asd91';
        $vo    = new Data($value);
        $this->assertSame($value, (string) $vo);
    }

    public function testConstructThrowsErrorOnEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s is empty', Data::NAME));
        new Data('');
    }
}
