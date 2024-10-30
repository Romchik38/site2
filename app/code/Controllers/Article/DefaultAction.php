<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\Article;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;
use Romchik38\Server\Controllers\Errors\ActionProcessException;
use Romchik38\Site2\Api\Models\ArticleTranslates\ArticleTranslatesInterface;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleInterface;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleRepositoryInterface;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleSearchCriteriaFactoryInterface;
use Romchik38\Site2\Models\DTO\Article\ArticleDTO;
use Romchik38\Site2\Models\DTO\Views\ArticleDefaultActionDTO\ArticleDefaultActionViewDTO;
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
        /** prepare databse query */
        $orderBy = ArticleOrderBy::byArtileId();
        $searchCriteria = $this->articleSearchCriteriaFactory->create();
        $searchCriteria->setOrderBy($orderBy);

        /** getting articles */
        $articleList = $this->articleRepository->list($searchCriteria);
        $articleDTOList = $this->mapArticleToDTO($articleList);

        /** prepare page view */
        $translatedPageName = $this->translateService->t($this::PAGE_NAME_KEY);
        $translatedPageDescription = $this->translateService->t($this::PAGE_DESCRIPTION_KEY);

        /** create a view dto */

        /** @todo replace with factory */
        $dto = new ArticleDefaultActionViewDTO(
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
     * @todo replace with an interface
     * @return ArticleDTO[]
    */
    protected function mapArticleToDTO(array $articleList): array {
        $dtos = [];
        foreach ($articleList as $article) {
            $translate = $this->getTranslate($article);
            $categories = $article->getAllCategories();
            $articleDTO = new ArticleDTO(
                $article->getId(),
                $article->getActive(),
                $translate->getName(),
                $translate->getShortDescription(),
                $translate->getDescription(),
                $translate->getCreatedAt(),
                $translate->getUpdatedAt(),
                array_map(fn($c)=> $c->getCategoryId(), $categories)
            );
            $dtos[] = $articleDTO;
        }
        
        return $dtos;
    }

    /**
     * @todo move to server 
     * Use to get default language 
     * */
    protected function getDefaultLanguage(): string
    {
        return $this->DynamicRootService->getDefaultRoot()->getName();
    }
}
