<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\Sitemap;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;
use Romchik38\Site2\Api\Views\SitemapLinkTreeInterface;
use Romchik38\Site2\Api\Models\DTO\Views\SitemapDTOFactoryInterface;
use Romchik38\Site2\Api\Models\Virtual\Link\Sql\LinkRepositoryInterface;
use Romchik38\Site2\Api\Models\Virtual\Link\LinkInterface;


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
        protected readonly SitemapDTOFactoryInterface $sitemapDTOFactory,
        protected readonly LinkRepositoryInterface $linkRepository
    ) {}

    public function execute(): string
    {
        $name = $this::DEFAULT_VIEW_NAME;
        $description = $this::DEFAULT_VIEW_DESCRIPTION;

        $path = $this->getPath();
        $links = $this->linkRepository->getLinksByLanguageAndPaths(
            $this->getLanguage(),
            [$path]
        );
        if (count($links) === 1) {
            /** @var LinkInterface $link */
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

    /** 
     * @todo move to action 
     * 
     * @return string[]
     * */
    protected function getPath(): array
    {
        $controller = $this->getController();
        $name = $controller->getName();
        $paths = [];
        $stop = false;
        $current = $controller;
        while ($stop === false) {
            $stop = true;
            $parent = $current->getCurrentParent();
            if ($parent !== null) {
                $stop = false;
                $current = $parent;
                array_unshift($paths, $parent->getName());
            }
        }
        array_push($paths, $name);

        return $paths;
    }

    /** @todo add to multilanguage action */
    protected function getLanguage(): string
    {
        return $this->DynamicRootService->getCurrentRoot()->getName();
    }
}
