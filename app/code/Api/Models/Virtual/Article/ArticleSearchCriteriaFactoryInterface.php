<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\Virtual\Article;

interface ArticleSearchCriteriaFactoryInterface
{
    public function create(
        string $limit = 'all',
        string $offset = '0',
        array $orderBy = []
    ): ArticleSearchCriteriaInterface;
}
