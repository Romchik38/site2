<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Visitor\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Visitor\VO\CsrfToken;

use function sprintf;

final class CsrfTokenTest extends TestCase
{
    public function testConstruct(): void
    {
        $value = 'qwertyuiopasdfghjkl1234d7hjhyure';
        $vo    = new CsrfToken($value);
        $this->assertSame($value, $vo());
    }

    public function testConstructThrowsErrorWrongLength(): void
    {
        $value = 'e';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(CsrfToken::LENGTH_ERROR_MESSAGE, CsrfToken::NAME, $value));

        new CsrfToken($value);
    }
}
