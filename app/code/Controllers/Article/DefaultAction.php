<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\Article;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;
use Romchik38\Server\Controllers\Errors\ActionProcessException;
use Romchik38\Site2\Api\Models\ArticleTranslates\ArticleTranslatesInterface;
use Romchik38\Site2\Api\Models\DTO\Article\ArticleDTOFactoryInterface;
use Romchik38\Site2\Api\Models\DTO\Article\ArticleDTOInterface;
use Romchik38\Site2\Api\Models\DTO\Views\Article\DefaultAction\ViewDTOFactoryInterface;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleInterface;
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
        protected readonly ViewDTOFactoryInterface $articleDefaultActionViewDTOFactory,
        protected readonly ArticleRepositoryInterface $articleRepository,
        protected readonly ArticleSearchCriteriaFactoryInterface $articleSearchCriteriaFactory,
        protected readonly ArticleDTOFactoryInterface $articleDTOFactory,
    ) {}

    public function execute(): string
    {
        /** prepare a database query */
        $orderBy = ArticleOrderBy::byArtileId();
        $searchCriteria = $this->articleSearchCriteriaFactory->create();
        $searchCriteria->setOrderBy($orderBy);

        /** getting articles from database */
        $articleList = $this->articleRepository->list($searchCriteria);
        $articleDTOList = $this->mapArticleToDTO($articleList);

        /** prepare page view */
        $translatedPageName = $this->translateService->t($this::PAGE_NAME_KEY);
        $translatedPageDescription = $this->translateService->t($this::PAGE_DESCRIPTION_KEY);

        /** create a view dto */
        $dto = $this->articleDefaultActionViewDTOFactory->create(
            $translatedPageName,
            $translatedPageDescription,
            $articleDTOList
        );

        /** create a view */
        $result = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return $result;
    }

    protected function getTranslate(ArticleInterface $article): ArticleTranslatesInterface
    {
        $translate = $article->getTranslate($this->getLanguage());

        if ($translate === null) {
            /** translate is missig, try to show default language */
            $translate = $article->getTranslate($this->getDefaultLanguage());
            if ($translate === null) {
                throw new ActionProcessException(
                    sprintf('Translate for article %s is missing', $article->getId())
                );
            }
        }

        return $translate;
    }

    /** 
     * @param ArticleInterface[] $articleList 
     *
     * @return ArticleDTOInterface[]
     */
    protected function mapArticleToDTO(array $articleList): array
    {
        /** $todo replace with cat mapper */
        $f = fn($c) => $c->getCategoryId();

        $dtos = [];
        foreach ($articleList as $article) {
            $translate = $this->getTranslate($article);
            $categories = $article->getAllCategories();
            $articleDTO = $this->articleDTOFactory->create(
                $article->getId(),
                $article->getActive(),
                $translate->getName(),
                $translate->getShortDescription(),
                $translate->getDescription(),
                $translate->getCreatedAt(),
                $translate->getUpdatedAt(),
                array_map($f, $categories),
                $translate->getReadLength()
            );
            $dtos[] = $articleDTO;
        }

        return $dtos;
    }

}
