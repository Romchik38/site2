<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\AdminRole\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\AdminRole\VO\Description;

final class DescriptionTest extends TestCase
{
    public function testInvoke(): void
    {
        $value = 'some_role';
        $d     = new Description($value);
        $this->assertSame($value, $d());
    }

    public function testToString(): void
    {
        $value = 'some_role';
        $d     = new Description($value);
        $this->assertSame($value, (string) $d);
    }

    public function testConstructThrowsErrorOnEmptyDescription(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param Admin role description is empty');
        new Description('');
    }
}
