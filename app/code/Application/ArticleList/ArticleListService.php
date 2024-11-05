<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleList;

use Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaFactoryInterface;
use Romchik38\Site2\Domain\Article\ArticleRepositoryInterface;
use Romchik38\Site2\Domain\Article\VO\ArticleId;

final class ArticleListService
{

    public function __construct(
        protected readonly ArticleRepositoryInterface $articleRepository,
        protected readonly SearchCriteriaFactoryInterface $searchCriteriaFactory,
        protected readonly ArticleFilterFactoryInterface $articleFilterFactory
    ) {}

    /** 
     *  Limit + offset
     *  Any sorting 
     *  Any filters
     * @param Pagination $pagination A CO to create a Search criteria
     * @return ArticleId[]
     */
    public function listArticles(Pagination $pagination): array
    {
        /** prepare a database query */
        // $orderBy = ArticleOrderBy::byArtileId();
        $searchCriteria = $this->searchCriteriaFactory->create(
            $pagination->limit(),
            $pagination->offset()
        );

        /** getting articles from database */
        $articleList = $this->articleRepository->list($searchCriteria);
        
        $articleIdList = [];
        foreach($articleList as $article){
            $articleIdList[] = $article->getId();
        }

        return $articleIdList;
    }

    /**
     * Limit + offset 
     * Filter active articles
     * @param Pagination $pagination A CO to create a Search criteria
     * @return ArticleId[]
     */
    public function listActiveArticles(Pagination $pagination): array
    {
        /** prepare a database query */
        // $orderBy = ArticleOrderBy::byArtileId();
        $searchCriteria = $this->searchCriteriaFactory->create(
            $pagination->limit(),
            $pagination->offset()
        );

        /** @var  ArticleSearchCriteria $searchCriteria */
        $searchCriteria->addFilter(
            $this->articleFilterFactory->active()
        );
        
        /** getting articles from the database */
        $articleList = $this->articleRepository->list($searchCriteria);
        
        $articleIdList = [];
        foreach($articleList as $article){
            $articleIdList[] = $article->getId();
        }

        return $articleIdList;
    }
}
