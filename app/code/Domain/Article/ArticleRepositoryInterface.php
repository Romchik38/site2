<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article;

use Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Domain\Article\VO\ArticleId;

/**
 * Manage Article entity
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
    public function list(SearchCriteriaInterface $searchCriteria): array;
}
