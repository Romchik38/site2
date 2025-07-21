<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Translate;

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Translate\Entities\Phrase;
use Romchik38\Site2\Domain\Translate\VO\Identifier;

final class TranslateTest extends TestCase
{
    public function testConstruct(): void
    {
        $id = new Identifier('key.1');
        
    }
}