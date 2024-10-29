<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\Virtual\Article;

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
    public function getById(string $id): ArticleInterface;
}
