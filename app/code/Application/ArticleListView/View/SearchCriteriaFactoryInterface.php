<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleListView\View;

interface SearchCriteriaFactoryInterface
{
    public function __invoke(
        string $offset,
        string $limit,
        string $orderByField,
        string $orderByDirection,
        string $language
    ): SearchCriteriaInterface;
}
