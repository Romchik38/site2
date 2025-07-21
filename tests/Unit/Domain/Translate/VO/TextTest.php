<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Translate\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Translate\VO\Text;

use function sprintf;

final class TextTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = 'some.text';
        $vo    = new Text($value);
        $this->assertSame($value, $vo());
    }

    public function testToString(): void
    {
        $value = 'some.text';
        $vo    = new Text($value);
        $this->assertSame($value, (string) $vo);
    }

    public function testConstructThrowsErrorOnEmptyPhrase(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s is empty', Text::NAME));
        new Text('');
    }
}
