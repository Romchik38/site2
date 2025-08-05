<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Visitor;

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Visitor\Visitor;

final class VisitorTest extends TestCase
{
    public function testAcceptWithTerms(): void
    {
        $v = new Visitor(false);

        $this->assertSame(false, $v->isAccepted);
        $v->acceptWithTerms();
        $this->assertSame(true, $v->isAccepted);
    }
}
