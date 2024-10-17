<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Api\Models\DTO\Html\Link\LinkDTOCollectionInterface;
use Romchik38\Server\Models\DTO\Html\Link\LinkDTO;
use Romchik38\Server\Models\DTO\Html\Link\LinkDTOCollection;
use Romchik38\Server\Models\DTO\Html\Link\LinkDTOFactory;

class LinkDTOCollectionTest extends TestCase
{
    protected $factory;

    public function setUp(): void
    {
        $this->factory = new LinkDTOFactory();
    }

    protected function createCollection(): LinkDTOCollectionInterface
    {
        return new class($this->factory) extends LinkDTOCollection {
            protected function getFromRepository(array $paths): array
            {
                $result = [];
                foreach ($paths as $path) {
                    $dto = $this->linkDTOFactory->create('Home', 'Home Page', implode('*', $path));
                    $this->hash[$this->serialize($path)] = $dto;
                    $result[] = $dto;
                }
                return $result;
            }
        };
    }

    public function testGetLinksByPaths()
    {
        $collection = $this->createCollection();

        $paths = [
            ['root', 'about']
        ];

        $result = $collection->getLinksByPaths($paths);

        $this->assertSame(1, count($result));

        $linkDTO = $result[0];

        $this->assertSame('Home', $linkDTO->getName());
        $this->assertSame('Home Page', $linkDTO->getDescription());
        $this->assertSame('root*about', $linkDTO->getUrl());
    }

    public function testGetAllLinks()
    {
        $collection = $this->createCollection();

        $paths = [
            ['root', 'about'],
            ['root'],
            ['root', 'products']
        ];

        $result = $collection->getLinksByPaths($paths);

        $this->assertSame(3, count($result));

        $linkDTOs = $collection->getAllLinks();

        $this->assertSame($result, $linkDTOs);
    }
}
