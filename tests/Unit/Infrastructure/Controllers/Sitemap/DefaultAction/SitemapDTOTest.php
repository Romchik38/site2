<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Infrastructure\Controllers\Sitemap\DefaultAction;

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\DefaultAction\SitemapDTO;

class SitemapDTOTest extends TestCase
{
    public function testGetOutput()
    {
        $output = 'Hello world';

        $dto = new SitemapDTO('Home', 'Home page', $output);

        $this->assertSame($output, $dto->getOutput());
    }
}
