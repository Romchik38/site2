<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Article;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;
use Romchik38\Site2\Application\ArticleListView\ArticleListViewService;
use Romchik38\Site2\Application\ArticleListView\Pagination as ArticleListViewPagination;
use Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction\Pagination;
use Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction\PaginationDTO;
use Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction\ViewDTOFactory;
use Romchik38\Site2\Infrastructure\Views\CreatePaginationInterface;

final class DefaultAction extends MultiLanguageAction implements DefaultActionInterface
{
    protected const PAGE_NAME_KEY = 'article.page_name';
    protected const PAGE_DESCRIPTION_KEY = 'article.description';

    public function __construct(
        protected readonly DynamicRootInterface $DynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly ViewDTOFactory $viewDTOFactory,
        protected readonly ArticleListViewService $articleListViewService,
        protected readonly CreatePaginationInterface $createPagination
    ) {}

    public function execute(): string
    {
        /** 1. decide which paginate to use */
        $pagination = Pagination::fromRequest(
            [
                'limit' => '5',
                //'page' => '0'
                // 'order_by' => 'identifier1',
                // 'order_direction' => 'desc'
            ],
            $this->articleListViewService->listTotal()
        );

        /** 2. do request to app service */
        $limit = $pagination->limit();
        $offset = (string)(((int)$pagination->page() - 1) * (int)$limit);
        $articleList = $this->articleListViewService->list(
            new ArticleListViewPagination(
                $limit,
                $offset,
                $pagination->orderByField(),
                $pagination->orderByDirection()
            ),
            $this->getLanguage()
        );

        $paginationDTO = new PaginationDTO(
            $this->createPagination::createHtml(
                (int)$pagination->page(),
                (int)$pagination->limit(),
                $pagination->totalCount(),
                count($articleList)
            )
        );


        /** 3. prepare a page view */
        $translatedPageName = $this->translateService->t($this::PAGE_NAME_KEY);
        $translatedPageDescription = $this->translateService->t($this::PAGE_DESCRIPTION_KEY);

        /** 4. create a view dto */
        $dto = $this->viewDTOFactory->create(
            $translatedPageName,
            $translatedPageDescription,
            $paginationDTO,
            $articleList
        );

        /** 5. create a view */
        $result = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return $result;
    }
}
