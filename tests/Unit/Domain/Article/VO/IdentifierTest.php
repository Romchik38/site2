<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Article\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Article\VO\Identifier;

use function sprintf;

final class IdentifierTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = 'some identifier';
        $d     = new Identifier($value);
        $this->assertSame($value, $d());
    }

    public function testToString(): void
    {
        $value = 'some identifier';
        $d     = new Identifier($value);
        $this->assertSame($value, (string) $d);
    }

    public function testConstructThrowsErrorOnEmptyIdentifier(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s is empty', Identifier::NAME));
        new Identifier('');
    }
}
