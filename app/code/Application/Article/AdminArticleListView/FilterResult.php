<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminArticleListView;

final class FilterResult
{
    public function __construct(
        public readonly SearchCriteria $searchCriteria,
        public readonly array $list
    ) {  
    }
}