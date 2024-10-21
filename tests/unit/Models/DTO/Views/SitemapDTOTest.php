<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Models\DTO\Views\SitemapDTO;

class SitemapDTOTest extends TestCase
{
    public function testGetOutput()
    {
        $output = 'Hello world';

        $dto = new SitemapDTO('Home', 'Home page', $output);

        $this->assertSame($output, $dto->getOutput());
    }
}
