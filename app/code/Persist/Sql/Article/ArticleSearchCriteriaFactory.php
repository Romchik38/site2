<?php

declare(strict_types=1);

namespace Romchik38\Site2\Persist\Sql\Article;

use Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaFactoryInterface;
use Romchik38\Server\Models\Sql\SearchCriteria\Limit;
use Romchik38\Site2\Persist\Sql\Article\ArticleSearchCriteria;

class ArticleSearchCriteriaFactory implements SearchCriteriaFactoryInterface {
    public function create(
        string $limit,
        string $offset = '0',
        array $orderBy = []
    ): ArticleSearchCriteria {
        return new ArticleSearchCriteria(
            new Limit($limit),
            $offset,
            $orderBy
        );
    }
}