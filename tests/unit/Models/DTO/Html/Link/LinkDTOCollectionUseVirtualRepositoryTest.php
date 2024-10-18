<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Models\DTO\Html\Link\LinkDTOCollectionUseVirtualRepository;
use Romchik38\Server\Models\DTO\Html\Link\LinkDTOFactory;
use Romchik38\Site2\Models\Link\Sql\LinkRepository;
use Romchik38\Server\Services\DynamicRoot\DynamicRoot;
use Romchik38\Server\Models\DTO\DynamicRoot\DynamicRootDTO;
use Romchik38\Server\Models\Sql\DatabasePostgresql;
use Romchik38\Site2\Models\Link\Link;
use Romchik38\Site2\Models\Link\LinkFactory;

class LinkDTOCollectionUseVirtualRepositoryTest extends TestCase
{
    protected $factory;
    protected $repository;
    protected $dynamicRoot;
    protected $dynamicRootDTO;
    protected $database;
    protected $linkFactory;

    public function setUp(): void
    {
        $this->factory = new LinkDTOFactory();
        $this->dynamicRoot = $this->createMock(DynamicRoot::class);
        $this->dynamicRootDTO = $this->createMock(DynamicRootDTO::class);
        $this->database = $this->createMock(DatabasePostgresql::class);
        $this->linkFactory = $this->createMock(LinkFactory::class);
    }

    public function testGetLinksByPaths()
    {
        $paths = [
            ['root', 'about']
        ];

        $language = 'uk';
        $name = 'Головна';
        $description = 'Головна сторінка';
        $linkId = '1';

        $model1 = [
            'path' => ['root', 'about'],
            'link_id' => $linkId,
            'language' => $language,
            'name' => $name,
            'description' => $description
        ];

        $this->database->method('queryParams')->willReturn([$model1]);
        $this->linkFactory->method('create')->willReturn(new Link());

        $repository = $this->createRepository();

        $this->dynamicRootDTO->method('getName')->willReturn($language);

        $this->dynamicRoot->expects($this->once())->method('getCurrentRoot')
            ->willReturn($this->dynamicRootDTO);

        $collection =  new LinkDTOCollectionUseVirtualRepository(
            $this->factory,
            $repository,
            $this->dynamicRoot
        );

        $result = $collection->getLinksByPaths($paths);

        $this->assertSame(1, count($result));

        $linkDTO = $result[0];

        $this->assertSame($name, $linkDTO->getName());
        $this->assertSame($description, $linkDTO->getDescription());
        $this->assertSame('/uk/about', $linkDTO->getUrl());
    }  

    protected function createRepository()
    {
        return new LinkRepository(
            $this->database,
            $this->linkFactory,
            ['links.path', 'links_translates.*'],
            ['links', 'links_translates']
        );
    }
}
