<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\Article;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;
use Romchik38\Site2\Controllers\Article\DefaultAction\ViewDTOFactory;
use Romchik38\Site2\Domain\Article\Detail\ArticleDetailRepository;
use Romchik38\Site2\Domain\Article\Services\ArticleListService;
use Romchik38\Site2\Domain\Article\Services\CO\Pagination;

final class DefaultAction extends MultiLanguageAction implements DefaultActionInterface
{
    protected const PAGE_NAME_KEY = 'article.page_name';
    protected const PAGE_DESCRIPTION_KEY = 'article.description';

    public function __construct(
        protected readonly DynamicRootInterface $DynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly ViewDTOFactory $viewDTOFactory,
        protected readonly ArticleListService $articleListService,
        protected readonly ArticleDetailRepository $articleDetailRepository
    ) {}

    public function execute(): string
    {
        /** 1. decide which paginate to use */
        $pagination = new Pagination();

        /** 2. do request to app service */
        $articleIdList = $this->articleListService->listArticles($pagination);

        $articleDTOList = [];
        foreach ($articleIdList as $articleId) {
            $articleDTOList[] = $this->articleDetailRepository
                ->getByIdAndLanguages(
                    $articleId,
                    [$this->getLanguage(), $this->getDefaultLanguage()]
                );
        }

        /** 3. prepare a page view */
        $translatedPageName = $this->translateService->t($this::PAGE_NAME_KEY);
        $translatedPageDescription = $this->translateService->t($this::PAGE_DESCRIPTION_KEY);

        /** 4. create a view dto */
        $dto = $this->viewDTOFactory->create(
            $translatedPageName,
            $translatedPageDescription,
            $articleDTOList
        );

        /** 5. create a view */
        $result = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return $result;
    }
}
