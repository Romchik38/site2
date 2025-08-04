<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Application\Search\Article\VO;

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Application\Search\Article\VO\Limit;

final class LimitTest extends TestCase
{
    public function testFromEmptyString(): void
    {
        $vo = Limit::fromString('15');

        $this->assertSame(Limit::DEFAULT_LIMIT, $vo());
    }
}
