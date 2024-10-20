<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\Sitemap;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;
use Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree;
use Romchik38\Site2\Api\Views\SitemapLinkTreeInterface;

/**
 * Creates a sitemap tree of public actions
 */
class DefaultAction extends MultiLanguageAction implements DefaultActionInterface
{

    public function __construct(
        protected readonly DynamicRootInterface $DynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly SitemapLinkTreeInterface $sitemapLinkTreeView,
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory
        /** ? */
        // protected readonly SitemapDTOFactoryInterface $sitemapDTOFactory,
        /** ? */
        // protected readonly MenuLinksRepositoryInterface $menuLinksRepository
    ) {}

    public function execute(): string
    {
        $output = $this
            ->sitemapLinkTreeView
            ->getSitemapLinkTree($this->getController(), '');

        /** @var MenuLinksInterface[] $menuLinks */
        // $menuLinks = $this->menuLinksRepository->list('', []);

        $sitemapDTO = $this->defaultViewDTOFactory->create(
            'Sitemap',
            'Sitemap Page'
        );


        // $sitemapDTO = $this->sitemapDTOFactory->create(
        //     'Sitemap',
        //     'Sitemap Page',
        //     $result,
        //     $menuLinks
        // );
        $this->view->setController($this->getController())
            ->setControllerData($sitemapDTO);

        return $this->view->toString();
    }
}
