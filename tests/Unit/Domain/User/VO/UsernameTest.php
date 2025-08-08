<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\User\VO;

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\User\VO\Username;

use function json_encode;

final class UsernameTest extends TestCase
{
    public function testJsonSerialize(): void
    {
        $value = 'some_name';
        $vo    = new Username($value);

        $this->assertSame(json_encode($value), json_encode($vo));
    }
}
