<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Category\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Category\VO\Identifier;

use function sprintf;

final class IdentifierTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = 'some identifier';
        $vo    = new Identifier($value);
        $this->assertSame($value, $vo());
    }

    public function testToString(): void
    {
        $value = 'some identifier';
        $vo    = new Identifier($value);
        $this->assertSame($value, (string) $vo);
    }

    public function testConstructThrowsErrorOnEmptyIdentifier(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('param %s is empty', Identifier::NAME));
        new Identifier('');
    }
}
