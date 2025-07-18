<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Translate\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Translate\VO\Phrase;

use function sprintf;

final class PhraseTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = 'some.text';
        $vo    = new Phrase($value);
        $this->assertSame($value, $vo());
    }

    public function testToString(): void
    {
        $value = 'some.text';
        $vo    = new Phrase($value);
        $this->assertSame($value, (string) $vo);
    }

    public function testConstructThrowsErrorOnEmptyPhrase(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s is empty', Phrase::NAME));
        new Phrase('');
    }
}
