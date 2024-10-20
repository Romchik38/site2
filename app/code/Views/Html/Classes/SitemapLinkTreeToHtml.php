<?php

declare(strict_types=1);

namespace Romchik38\Site2\Views\Html\Classes;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Models\DTO\Http\LinkTree\LinkTreeDTOInterface;
use Romchik38\Server\Api\Services\Mappers\LinkTree\Http\LinkTreeInterface;
use Romchik38\Server\Api\Services\Mappers\SitemapInterface;
use Romchik38\Site2\Api\Views\SitemapLinkTreeInterface;

/**
 * Maps ControllerDTO to Html throughth LinkTreeDTO
 */
final class SitemapLinkTreeToHtml implements SitemapLinkTreeInterface
{
    public function __construct(
        protected SitemapInterface $sitemapService,
        protected LinkTreeInterface $linkTreeService
    ) {}

    /** @return string Html */
    public function getSitemapLinkTree(ControllerInterface $controller, string $action): mixed
    {
        $rootcontrollerDTO = $this->sitemapService->getRootControllerDTO($controller, $action);
        $linkTreeDTO = $this->linkTreeService->getLinkTreeDTO($rootcontrollerDTO);
        return $this->buildHtml($linkTreeDTO);
    }

    protected function buildHtml(LinkTreeDTOInterface $linkTreeDTO): string
    {
        return 'from sitemap link tree mapper';
    }
}
