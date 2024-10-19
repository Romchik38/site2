<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Mappers\LinkTree\Http;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOInterface;
use Romchik38\Server\Api\Models\DTO\Http\Link\LinkDTOCollectionInterface;
use Romchik38\Server\Api\Models\DTO\Http\LinkTree\LinkTreeDTOFactoryInterface;
use Romchik38\Server\Api\Models\DTO\Http\LinkTree\LinkTreeDTOInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Mappers\SitemapInterface;

/** 
 * Maps Root ControllerDTO LinkTreeDTO
 * 
 * @todo create an interface
 */
class LinkTree
{
    protected string $currentRoot = SitemapInterface::ROOT_NAME;

    public function __construct(
        protected SitemapInterface $sitemapService,
        protected LinkTreeDTOFactoryInterface $linkTreeDTOFactory,
        protected LinkDTOCollectionInterface $linkDTOCollection,
        protected DynamicRootInterface|null $dynamicRoot = null
    ) {}

    /** 
     * @todo add return type LinkTreeDTOInterface
     */
    public function getLinkTreeDTO(ControllerInterface $controller, string $action)
    {
        /** 
         * 1 Set Dynamic root if exist 
         */
        if ($this->dynamicRoot !== null) {
            $this->currentRoot = $this->dynamicRoot->getCurrentRoot()->getName();
        }

        /** 2. Get ControllerDTOInterface */
        $RootcontrollerDTO = $this->sitemapService->getRootControllerDTO($controller, $action);

        /** 3. Get LinkDTOs */
        $paths = $this->getPathsFromControllerDTO($RootcontrollerDTO);
        $linkDTOs = $this->linkDTOCollection->getLinksByPaths($paths);
        $linkHash = [];
        foreach ($linkDTOs as $linkDTO) {
            $linkHash[$linkDTO->getUrl()] = $linkDTO;
        }

        /** 4. Build controllerDTO hash */
        $controllerDTOHash = $this->buildControllerDTOHash($RootcontrollerDTO);


    }

    /**
     * @todo implement
     *  
     * @return array<int,string[]>
     * */
    protected function getPathsFromControllerDTO(ControllerDTOInterface $dto): array
    {
        return [];
    }

    /**
     * $hash = [
     *  'key' => [
     *      'parrents' => [],
     *      'children' => []
     *      ]
     * ]
     */
    /** 
     * @todo implement
     * @todo add return type 
     * 
     * Used in getLinkTreeDTO
     */
    protected function buildControllerDTOHash(ControllerDTOInterface $element, $hash = []) {       
        $key = get_class($element);
        $children = $element->getChildren();
        
        $hash[$key] ?? 
    }
}
