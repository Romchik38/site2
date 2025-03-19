<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views\Html\Classes;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Models\DTO\Http\LinkTree\LinkTreeDTOInterface;
use Romchik38\Server\Api\Services\Mappers\ControllerTreeInterface;
use Romchik38\Server\Api\Services\Mappers\LinkTree\Http\LinkTreeInterface;
use Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Sitemap\SitemapLinkTreeInterface;

use function count;
use function htmlspecialchars;
use function implode;
use function sprintf;

/**
 * Maps ControllerDTO to Html throughth LinkTreeDTO.
 * Used in the Sitemap action only
 *
 * @internal
 */
final class SitemapLinkTreeToHtml implements SitemapLinkTreeInterface
{
    public function __construct(
        protected ControllerTreeInterface $controllerTreeService,
        protected LinkTreeInterface $linkTreeService
    ) {
    }

    /**
     * Converts controller tree to HTML format
     *
     * @return string valid Html
     * */
    public function getSitemapLinkTree(ControllerInterface $controller): mixed
    {
        $rootControllerDto = $this->controllerTreeService->getRootControllerDto($controller);
        $linkTreeDto       = $this->linkTreeService->getLinkTreeDTO($rootControllerDto);
        return $this->buildHtml($linkTreeDto);
    }

    protected function buildHtml(LinkTreeDTOInterface $linkTreeDto): string
    {
        return '<ul>' . $this->createRow($linkTreeDto) . '</ul>';
    }

    /**
     * Recursively creates html <li> and <ul> tags
     *
     * @return string <li>inner html</li>
     */
    protected function createRow(LinkTreeDTOInterface $element): string
    {
        $children    = $element->getChildren();
        $description = $element->getDescription();
        $url         = $element->getUrl();

        // 1. the element has not children
        if (count($children) === 0) {
            $elemNameHtml = sprintf(
                '<a href="%s" title="%s">%s</a>',
                htmlspecialchars($url),
                htmlspecialchars($description),
                htmlspecialchars($description)
            );
            return '<li>' . $elemNameHtml . '</li>';
        }

        // 2. the element has children
        $rowNameHtml     = sprintf(
            '<a href="%s" title="%s">%s</a>',
            htmlspecialchars($url),
            htmlspecialchars($description),
            htmlspecialchars($description)
        );
        $rowElementsHtml = [];
        foreach ($children as $child) {
            $rowElemHtml       = $this->createRow($child);
            $rowElementsHtml[] = $rowElemHtml;
        }
        return '<li>' . $rowNameHtml . '<ul>' . implode('', $rowElementsHtml) . '</ul></li>';
    }
}
