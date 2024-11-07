<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Sitemap;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;
use Romchik38\Site2\Application\LinkCollection\LinkCollectionService;
use Romchik38\Site2\Infrastructure\Controllers\Sitemap\DefaultAction\SitemapDTOFactory;

/**
 * Creates a sitemap tree of public actions
 */
class DefaultAction extends MultiLanguageAction implements DefaultActionInterface
{
    const DEFAULT_VIEW_NAME = 'Sitemap';
    const DEFAULT_VIEW_DESCRIPTION = 'Public sitemap - visit all our resources';

    public function __construct(
        protected readonly DynamicRootInterface $DynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly SitemapLinkTreeInterface $sitemapLinkTreeView,
        protected readonly SitemapDTOFactory $sitemapDTOFactory,
        protected readonly LinkCollectionService $linkCollectionService
    ) {}

    public function execute(): string
    {
        $name = $this::DEFAULT_VIEW_NAME;
        $description = $this::DEFAULT_VIEW_DESCRIPTION;

        $path = $this->getPath();
        $links = $this->linkCollectionService->getLinksByPaths([$path]);
        if (count($links) === 1) {
            $link = $links[0];
            $name = $link->getName();
            $description = $link->getDescription();
        }

        $output = $this->sitemapLinkTreeView
            ->getSitemapLinkTree($this->getController());

        $sitemapDTO = $this->sitemapDTOFactory->create(
            $name,
            $description,
            $output
        );

        $this->view->setController($this->getController())
            ->setControllerData($sitemapDTO);

        return $this->view->toString();
    }

}
