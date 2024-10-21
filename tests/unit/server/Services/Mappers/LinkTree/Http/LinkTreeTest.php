<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOInterface;
use Romchik38\Server\Api\Services\Mappers\Breadcrumb\Http\BreadcrumbInterface;
use Romchik38\Server\Models\DTO\Http\LinkTree\LinkTreeDTOFactory;
use Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree;
use Romchik38\Server\Models\DTO\Controller\ControllerDTO;

class LinkTreeTest extends TestCase
{
    protected LinkTreeDTOFactory $linkTreeDTOFactory;

    public function setUp(): void
    {
        $this->linkTreeDTOFactory = new LinkTreeDTOFactory();
    }

    public function testGetLinkTreeDTOWithoutDynamicRootandWithoutCollection(): void
    {
        $rootControllerDTO = $this->createRootControllerDTO();

        $linkTreeService = new LinkTree($this->linkTreeDTOFactory);
        $dto = $linkTreeService->getLinkTreeDTO($rootControllerDTO);

        $this->assertSame(BreadcrumbInterface::HOME_PLACEHOLDER, $dto->getName());
        $this->assertSame(BreadcrumbInterface::HOME_PLACEHOLDER, $dto->getDescription());
        $this->assertSame('/', $dto->getUrl());

        $children = $dto->getChildren();
        $this->assertSame(2, count($children));

        [$child1, $child2] = $children;

        $this->assertSame('about', $child1->getName());
        $this->assertSame('about', $child1->getDescription());
        $this->assertSame('/about', $child1->getUrl());

        $this->assertSame('sitemap', $child2->getName());
        $this->assertSame('sitemap', $child2->getDescription());
        $this->assertSame('/sitemap', $child2->getUrl());
    }

    protected function createRootControllerDTO(): ControllerDTOInterface
    {
        $child1 = new ControllerDTO('about', ['root'], []);
        $child2 = new ControllerDTO('sitemap', ['root'], []);
        $rootControllerDTO = new ControllerDTO('root', [], [$child1, $child2]);
        return $rootControllerDTO;
    }
}
