<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\Article;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleRepositoryInterface;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleSearchCriteriaFactoryInterface;
use Romchik38\Site2\Models\Virtual\Article\Sql\ArticleOrderBy;

final class DefaultAction extends MultiLanguageAction implements DefaultActionInterface
{
    protected const PAGE_NAME_KEY = 'article.page_name';
    protected const PAGE_DESCRIPTION_KEY = 'article.description';

    public function __construct(
        protected readonly DynamicRootInterface $DynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        /** @todo create Article DTO */
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory,
        protected readonly ArticleRepositoryInterface $articleRepository,
        protected readonly ArticleSearchCriteriaFactoryInterface $articleSearchCriteriaFactory
    ) {}

    public function execute(): string
    {
        $orderBy = ArticleOrderBy::byArtileId();
        $searchCriteria = $this->articleSearchCriteriaFactory->create();
        $searchCriteria->setOrderBy($orderBy);

        $articleList = $this->articleRepository->list($searchCriteria);

        /** @todo replace with a list of articles */
        $result = $this->articleRepository->getById('article-2');

        $translatedPageName = $this->translateService->t($this::PAGE_NAME_KEY);
        $translatedPageDescription = $this->translateService->t($this::PAGE_DESCRIPTION_KEY);

        $dto = $this->defaultViewDTOFactory->create(
            $translatedPageName,
            $translatedPageDescription
        );

        $result = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return $result;
    }
}
