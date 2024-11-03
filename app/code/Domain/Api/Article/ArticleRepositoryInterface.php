<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Api\Article;

use Romchik38\Server\Models\Sql\SearchCriteria\SearchCriteria;
use Romchik38\Site2\Domain\Article\Article;
use Romchik38\Site2\Domain\Article\VO\ArticleId;

/**
 * Manage Article entity
 * @api
 */
interface ArticleRepositoryInterface
{

    /** 
     * Retrives an article entity from database
     * 
     * @param ArticleId $id entity id.
     * @throws NoSuchEntityException
     * @return Article An article entity
     */
    public function getById(ArticleId $id): Article;

    /**
     * @return Article[]
     */
    public function list(SearchCriteria $searchCriteria): array;
}
