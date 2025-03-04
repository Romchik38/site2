<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Article;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Services\Urlbuilder\UrlbuilderFactoryInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Controllers\Errors\ActionNotFoundException;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Site2\Application\ArticleListView\ArticleListViewService;
use Romchik38\Site2\Application\ArticleListView\Pagination as ArticleListViewPagination;
use Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction\Pagination;
use Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction\ViewDTO;
use Romchik38\Site2\Infrastructure\Views\CreatePaginationFactoryInterface;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    protected const PAGE_NAME_KEY = 'article.page_name';
    protected const PAGE_DESCRIPTION_KEY = 'article.description';

    public function __construct(
        protected DynamicRootInterface $dynamicRootService,
        protected TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly ArticleListViewService $articleListViewService,
        protected readonly CreatePaginationFactoryInterface $createPaginationFactory,
        protected readonly ServerRequestInterface $request,
        protected readonly UrlbuilderFactoryInterface $urlbuilderFactory
    ) {}

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

        /** @todo replace with new one */
        $urlBuilder = $this->urlbuilderFactory->create(
            $this->getPath(),
            $this->getLanguage()
        );

        $paginationView = $this->createPaginationFactory->create(
            $urlBuilder,
            $pagination,
            count($articleList)
        );

        /** 4. create a view dto */
        $dto = new ViewDTO(
            $translatedPageName,
            $translatedPageDescription,
            $articleList,
            $paginationView,
            $urlBuilder
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
