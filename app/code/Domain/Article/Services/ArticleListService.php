<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\Services;

use Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaFactoryInterface;
use Romchik38\Site2\Domain\Api\Article\ArticleRepositoryInterface;
use Romchik38\Site2\Domain\Article\Services\DO\Pagination;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Persist\Sql\Article\ArticleSearchCriteria;
use Romchik38\Site2\Persist\Sql\Article\Filters\ArticleFilter;

final class ArticleListService
{

    public function __construct(
        protected readonly ArticleRepositoryInterface $articleRepository,
        protected readonly SearchCriteriaFactoryInterface $searchCriteriaFactory
    ) {}

    /** Any sorting 
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

    /** Show only active articles
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
        $searchCriteria->addFilter(ArticleFilter::active());
        
        /** getting articles from database */
        $articleList = $this->articleRepository->list($searchCriteria);
        
        $articleIdList = [];
        foreach($articleList as $article){
            $articleIdList[] = $article->getId();
        }

        return $articleIdList;
    }
}
