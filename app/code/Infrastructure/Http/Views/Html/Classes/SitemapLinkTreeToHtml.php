<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html\Classes;

use Romchik38\Server\Http\Controller\ControllerInterface;
use Romchik38\Server\Http\Controller\Mappers\ControllerTree\ControllerTreeInterface;
use Romchik38\Server\Http\Controller\Mappers\LinkTree\LinkTreeDTOInterface;
use Romchik38\Server\Http\Controller\Mappers\LinkTree\LinkTreeInterface;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\SitemapLinkTreeInterface;

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
        private ControllerTreeInterface $controllerTreeService,
        private LinkTreeInterface $linkTreeService
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

    private function buildHtml(LinkTreeDTOInterface $linkTreeDto): string
    {
        return '<ul class="list-group">' . $this->createRow($linkTreeDto) . '</ul>';
    }

    /**
     * Recursively creates html <li> and <ul> tags
     *
     * @return string <li>inner html</li>
     */
    private function createRow(LinkTreeDTOInterface $element): string
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
            return '<li class="list-group-item">' . $elemNameHtml . '</li>';
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
        $template = <<<TEMPLATE
        <li class="list-group-item bg-light">
            <details>
                <summary>%s</summary>
                <ul class="list-group">%s</ul>
            </details>
        </li>
        TEMPLATE;
        return sprintf($template, $rowNameHtml, implode('', $rowElementsHtml));
    }
}
