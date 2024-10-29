<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Virtual\Article;

use Romchik38\Site2\Api\Models\Virtual\Article\ArticleSearchCriteriaFactoryInterface;

final class ArticleSearchCriteriaFactory implements ArticleSearchCriteriaFactoryInterface
{
    public function create($limit = 'all', $offset = '0', ?bool $active = null)
    {
        return new ArticleSearchCriteria(
            $limit,
            $offset,
            $active
        );
    }
}
