<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Breadcrumb\Http;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOInterface;
use Romchik38\Server\Api\Models\DTO\Html\Breadcrumb\BreadcrumbDTOFactoryInterface;
use Romchik38\Server\Api\Models\DTO\Html\Breadcrumb\BreadcrumbDTOInterface;
use Romchik38\Server\Api\Models\DTO\Html\Link\LinkDTOCollectionInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\SitemapInterface;

/** @todo create an Interface */
class Breadcrumb
{
    protected string $currentRoot = SitemapInterface::ROOT_NAME;

    public function __construct(
        protected SitemapInterface $sitemapService,
        protected BreadcrumbDTOFactoryInterface $breadcrumbDTOFactory,
        protected LinkDTOCollectionInterface $linkDTOCollection,
        protected DynamicRootInterface|null $dynamicRoot = null
    ) {
    }

    public function getBreadcrumbDTO(ControllerInterface $controller, string $action): BreadcrumbDTOInterface {
        /** 0 Set Dynamic root if exist */
        if($this->dynamicRoot !== null) {
            $this->currentRoot = $this->dynamicRoot->getCurrentRoot()->getName();
        }

        /** 1. Get ControllerDTOInterface */
        $controllerDTO = $this->sitemapService->getOnlyLineRootControllerDTO($controller, $action);
        
        /** 2. Get LinkDTOs */
        $paths = $this->getPathsFromControllerDTO($controllerDTO);
        $linkDTOs = $this->linkDTOCollection->getLinksByPaths($paths);
        $linkHash = [];
        foreach ($linkDTOs as $linkDTO) {
            $linkHash[$linkDTO->getUrl()] = $linkDTO;
        }

        /** get breadcrumbDTO */
        $breadcrumbDTO = $this->mapControllerDTOtoBreadcrumbDTO($controllerDTO, null, $linkHash);

        return $breadcrumbDTO;
    }

    protected function getPathsFromControllerDTO(ControllerDTOInterface $dto) {
        $stop = false;
        $paths = [];
        $current = $dto;
        while($stop === false) {
            $stop = true;
            $paths[] = array_merge($current->getPath(), [$current->getName()]);
            $children = $current->getChildren();
            if (count($children) > 0) {
                $stop = false;
                $current = $children[0];
            }
        }
        return $paths;
    }

    protected function mapControllerDTOtoBreadcrumbDTO(
        ControllerDTOInterface $controllerDTO,
        BreadcrumbDTOInterface|null $prev,
        array $hash
    ): BreadcrumbDTOInterface {

        $name = $controllerDTO->getName();
        $path = $controllerDTO->getPath();

        array_push($path, $name);

        $path[0] = $this->currentRoot;

        if ($name === SitemapInterface::ROOT_NAME) {
            $name = 'home';
        }

        $url = '/' . implode('/', $path);

        /** @var Romchik38\Server\Api\Models\DTO\Html\Link\LinkDTOInterface $linkDTO */
        $linkDTO = $hash[$url] ?? null;
        $description = '';
        if ($linkDTO !== null) {
            $name = $linkDTO->getName();
            $description = $linkDTO->getDescription();
        }

        $element = $this->breadcrumbDTOFactory->create(
            $name,
            $description,
            $url,
            $prev
        );

        $children = $controllerDTO->getChildren();
        if (count($children) > 0) {
            $child = $children[0];
            return $this->mapControllerDTOtoBreadcrumbDTO($child, $element, $hash);
        } else {
            return $element;
        }
    }
}
