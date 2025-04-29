<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Translate\TranslateInterface;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\DefaultAction\SitemapDTOFactory;

/**
 * Creates a sitemap tree of public actions
 */
final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const DEFAULT_VIEW_NAME        = 'sitemap.page_name';
    private const DEFAULT_VIEW_DESCRIPTION = 'sitemap.description';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly SitemapLinkTreeInterface $sitemapLinkTreeView,
        private readonly SitemapDTOFactory $sitemapDtoFactory
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $output = $this->sitemapLinkTreeView
            ->getSitemapLinkTree($this->getController());

        $sitemapDto = $this->sitemapDtoFactory->create(
            $this->translateService->t($this::DEFAULT_VIEW_NAME),
            $this->translateService->t($this::DEFAULT_VIEW_DESCRIPTION),
            $output
        );

        $this->view->setController($this->getController())
            ->setControllerData($sitemapDto);
        $html = $this->view->toString();
        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return $this->translateService->t($this::DEFAULT_VIEW_NAME);
    }
}
