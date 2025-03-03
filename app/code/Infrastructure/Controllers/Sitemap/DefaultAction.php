<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Sitemap;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Site2\Infrastructure\Controllers\Sitemap\DefaultAction\SitemapDTOFactory;

/**
 * Creates a sitemap tree of public actions
 */
class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    const DEFAULT_VIEW_NAME = 'sitemap.page_name';
    const DEFAULT_VIEW_DESCRIPTION = 'sitemap.description';

    public function __construct(
        protected readonly DynamicRootInterface $dynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly SitemapLinkTreeInterface $sitemapLinkTreeView,
        protected readonly SitemapDTOFactory $sitemapDTOFactory
    ) {
    }

    public function execute(): ResponseInterface
    {
        $output = $this->sitemapLinkTreeView
            ->getSitemapLinkTree($this->getController());

        $sitemapDTO = $this->sitemapDTOFactory->create(
            $this->translateService->t($this::DEFAULT_VIEW_NAME),
            $this->translateService->t($this::DEFAULT_VIEW_DESCRIPTION),
            $output
        );

        $this->view->setController($this->getController())
            ->setControllerData($sitemapDTO);
        $html = $this->view->toString();
        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return $this->translateService->t($this::DEFAULT_VIEW_NAME);
    }
}
