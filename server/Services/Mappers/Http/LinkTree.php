<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Mappers\Http;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOInterface;
use Romchik38\Server\Api\Models\DTO\Html\Link\LinkDTOCollectionInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\SitemapInterface;

/** 
 * Maps Root ControllerDTO LinkTreeDTO
 * 
 * @todo create an interface
 */
class LinkTree {
    protected string $currentRoot = SitemapInterface::ROOT_NAME;

    public function __construct(
        protected SitemapInterface $sitemapService,
        protected LinkTreeDTOFactoryInterface $linkTreeDTOFactory,
        protected LinkDTOCollectionInterface $linkDTOCollection,
        protected DynamicRootInterface|null $dynamicRoot = null
    ) {}

    public function getLinkTreeDTO(ControllerInterface $controller, string $action): LinkTreeDTOInterface {
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

        /** 4. get LinkTreeDTO */
        $LinkTreeDTO = $this->createElement($RootcontrollerDTO);

        return $LinkTreeDTO;
    }

    /**
     * @todo implement
     *  
     * @return array<int,string[]>
     * */
    protected function getPathsFromControllerDTO(ControllerDTOInterface $dto): array {
        return [];
    }

    /** 
     * @todo implement
     * @todo add return type 
     * 
     * used in getLinkTreeDTO
     */
    protected function createElement(ControllerInterface $element, $parentName = '', $parrentPath = []) {
        
    }


}