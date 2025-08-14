<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Page\View\Commands\Find\Find;
use Romchik38\Site2\Application\Page\View\CouldNotFindException;
use Romchik38\Site2\Application\Page\View\NoSuchPageException;
use Romchik38\Site2\Application\Page\View\ViewService as PageService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\DefaultAction\ViewDTO;
use RuntimeException;

use function sprintf;

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
        private readonly PageService $pageService,
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Page
        $command = new Find('sitemap', $this->getLanguage());
        try {
            $page = $this->pageService->find($command);
        } catch (NoSuchPageException) {
            throw new RuntimeException('Register view action error: page with url login not found');
        } catch (CouldNotFindException $e) {
            throw new RuntimeException(sprintf('Register view action error %s: ', $e->getMessage()));
        }

        $output = $this->sitemapLinkTreeView
            ->getSitemapLinkTree($this->getController());

        $sitemapDto = new ViewDTO(
            $this->translateService->t($this::DEFAULT_VIEW_NAME),
            $this->translateService->t($this::DEFAULT_VIEW_DESCRIPTION),
            $output,
            $page
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
