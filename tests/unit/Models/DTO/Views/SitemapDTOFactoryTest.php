<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site2\Models\DTO\Views\SitemapDTOFactory;

class SitemapDTOFactoryTest extends TestCase
{
    public function testCreate()
    {
        $name = 'Home';
        $description = 'Home Page';
        $output = 'Hello world';

        $factory = new SitemapDTOFactory();
        $dto = $factory->create($name, $description, $output);

        $this->assertSame($name, $dto->getName());
        $this->assertSame($description, $dto->getDescription());
        $this->assertSame($output, $dto->getOutput());
    }

    public function testCreateThrowsErrorEmptyName()
    {
        $name = '';
        $description = 'Home Page';
        $output = 'Hello world';

        $this->expectException(InvalidArgumentException::class);
        $factory = new SitemapDTOFactory();

        $factory->create($name, $description, $output);
    }

    public function testCreateThrowsErrorEmptyDescription()
    {
        $name = 'Home';
        $description = '';
        $output = 'Hello world';

        $this->expectException(InvalidArgumentException::class);
        $factory = new SitemapDTOFactory();

        $factory->create($name, $description, $output);
    }

    public function testCreateThrowsErrorEmptyoutput()
    {
        $name = 'Home';
        $description = 'Home Page';
        $output = '';

        $this->expectException(InvalidArgumentException::class);
        $factory = new SitemapDTOFactory();

        $factory->create($name, $description, $output);
    }
}
