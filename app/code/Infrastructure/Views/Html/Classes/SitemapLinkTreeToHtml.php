<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views\Html\Classes;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Models\DTO\Http\LinkTree\LinkTreeDTOInterface;
use Romchik38\Server\Api\Services\Mappers\LinkTree\Http\LinkTreeInterface;
use Romchik38\Server\Api\Services\Mappers\SitemapInterface;
use Romchik38\Site2\Api\Views\SitemapLinkTreeInterface;

/**
 * 
 * Maps ControllerDTO to Html throughth LinkTreeDTO.
 * Used in the Sitemap action only
 * 
 * @internal
 */
final class SitemapLinkTreeToHtml implements SitemapLinkTreeInterface
{
    public function __construct(
        protected SitemapInterface $sitemapService,
        protected LinkTreeInterface $linkTreeService
    ) {}

    /** 
     * Converts controller tree to HTML format
     * 
     * @return string valid Html 
     * */
    public function getSitemapLinkTree(ControllerInterface $controller): mixed
    {
        $rootControllerDTO = $this->sitemapService->getRootControllerDTO($controller);
        $linkTreeDTO = $this->linkTreeService->getLinkTreeDTO($rootControllerDTO);
        return $this->buildHtml($linkTreeDTO);
    }

    protected function buildHtml(LinkTreeDTOInterface $linkTreeDTO): string
    {
        return '<ul>' . $this->createRow($linkTreeDTO) . '</ul>';
    }

    /** 
     * Recursively creates html <li> and <ul> tags
     * 
     * @return string <li>inner html</li>
     */
    protected function createRow(LinkTreeDTOInterface $element): string
    {
        $children = $element->getChildren();
        $name = $element->getName();
        $description = $element->getDescription();
        $url = $element->getUrl();

        // 1. the element has not children
        if (count($children) === 0) {
            $elemNameHtml = '<a href="' . htmlspecialchars($url) . '" title="' . htmlspecialchars($description) . '">' . htmlspecialchars($name) . '</a>';
            $lastElementHtml = '<li>' . $elemNameHtml . '</li>';
            return $lastElementHtml;
        }

        // 2. the element has children
        $rowNameHtml = '<a href="' . htmlspecialchars($url) . '" title="' . htmlspecialchars($description) . '">' . htmlspecialchars($name) . '</a>';
        $rowElementsHtml = [];
        foreach ($children as $child) {
            $rowElemHtml = $this->createRow($child);
            $rowElementsHtml[] = $rowElemHtml;
        }
        return '<li>' . $rowNameHtml . '<ul>' . implode('', $rowElementsHtml) . '</ul></li>';
    }
}
