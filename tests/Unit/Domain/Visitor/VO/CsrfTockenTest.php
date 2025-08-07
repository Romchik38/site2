<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Visitor\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Visitor\VO\CsrfTocken;

use function sprintf;

final class CsrfTockenTest extends TestCase
{
    public function testConstruct(): void
    {
        $value = 'qwertyuiopasdfghjkl1234d7hjhyure';
        $vo    = new CsrfTocken($value);
        $this->assertSame($value, $vo());
    }

    public function testConstructThrowsErrorWrongLength(): void
    {
        $value = 'e';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(CsrfTocken::LENGTH_ERROR_MESSAGE, CsrfTocken::NAME, $value));

        new CsrfTocken($value);
    }
}
