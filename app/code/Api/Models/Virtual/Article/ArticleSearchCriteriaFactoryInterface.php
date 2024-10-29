<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\Virtual\Article;

interface ArticleSearchCriteriaFactoryInterface
{
    public function create(
        $limit = 'all',
        $offset = '0',
        bool|null $active = null
    );
}
