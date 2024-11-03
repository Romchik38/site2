<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Api\Article;

use Romchik38\Server\Models\Sql\SearchCriteria\SearchCriteria;
use Romchik38\Site2\Domain\Article\Article;
use Romchik38\Site2\Models\Virtual\Article\Sql\ArticleSearchCriteria;

/**
 * Manage Article entity
 * @api
 */
interface ArticleRepositoryInterface
{

    /** 
     * Retrives an article entity from database
     * 
     * @param string $id An entity id.
     * @throws NoSuchEntityException
     * @return ArticleInterface An article entity
     */
    public function getById(string $id): Article;

    /**
     * @return ArticleInterface[]
     */
    public function list(SearchCriteria $searchCriteria): array;
}
