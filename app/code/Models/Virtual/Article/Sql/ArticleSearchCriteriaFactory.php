<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Virtual\Article\Sql;

use Romchik38\Site2\Api\Models\Virtual\Article\ArticleSearchCriteriaFactoryInterface;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleSearchCriteriaInterface;

final class ArticleSearchCriteriaFactory implements ArticleSearchCriteriaFactoryInterface
{
    public function create(
        string $limit = 'all',
        string $offset = '0',
        array $orderBy = []
    ): ArticleSearchCriteriaInterface {
        return new ArticleSearchCriteria(
            $limit,
            $offset,
            $orderBy
        );
    }
}
