<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Article\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Article\VO\ShortDescription;

use function sprintf;

final class ShortDescriptionTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = 'some description';
        $d     = new ShortDescription($value);
        $this->assertSame($value, $d());
    }

    public function testToString(): void
    {
        $value = 'some description';
        $d     = new ShortDescription($value);
        $this->assertSame($value, (string) $d);
    }

    public function testConstructThrowsErrorOnEmptyDescription(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s is empty', ShortDescription::NAME));
        new ShortDescription('');
    }
}
