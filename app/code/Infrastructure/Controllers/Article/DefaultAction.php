<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Article;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Controllers\Errors\ActionNotFoundException;
use Romchik38\Server\Controllers\Path;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Application\ArticleListView\ArticleListViewService;
use Romchik38\Site2\Application\ArticleListView\Pagination as ArticleListViewPagination;
use Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction\Pagination;
use Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction\ViewDTO;
use Romchik38\Site2\Infrastructure\Views\Html\Classes\ArticleCreatePagination;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    protected const PAGE_NAME_KEY = 'article.page_name';
    protected const PAGE_DESCRIPTION_KEY = 'article.description';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly ArticleListViewService $articleListViewService,
        protected readonly ServerRequestInterface $request,
        protected readonly UrlbuilderInterface $urlbuilder,
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $requestData = $this->request->getQueryParams();

        /** 1. Create pagination DTO */
        try {
            $pagination = Pagination::fromRequest(
                $requestData,
                $this->articleListViewService->listTotal()
            );
        } catch (InvalidArgumentException $e) {
            throw new ActionNotFoundException('Check requested parameters.' . $e->getMessage());
        }

        /** 2. Do request to app service */
        $articleList = $this->articleListViewService->list(
            new ArticleListViewPagination(
                $pagination->limit(),
                $pagination->offset,
                $pagination->orderByField(),
                $pagination->orderByDirection()
            ),
            $this->getLanguage()
        );

        /** 3. prepare a page view */
        $translatedPageName = $this->translateService->t($this::PAGE_NAME_KEY);
        $translatedPageDescription = $this->translateService->t($this::PAGE_DESCRIPTION_KEY);

        $path = new Path($this->getPath());
        $paginationView = new ArticleCreatePagination(
            $path,
            $this->urlbuilder,
            $pagination,
            count($articleList)
        );

        /** 4. create a view dto */
        $dto = new ViewDTO(
            $translatedPageName,
            $translatedPageDescription,
            $articleList,
            $paginationView,
            $this->urlbuilder->fromPath($path)
        );

        /** 5. create a view */
        $result = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($result);
    }

    public function getDescription(): string
    {
        return $this->translateService->t($this::PAGE_NAME_KEY);
    }
}
