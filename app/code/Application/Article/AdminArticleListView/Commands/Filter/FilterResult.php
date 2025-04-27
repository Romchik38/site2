<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminArticleListView\Commands\Filter;

use Romchik38\Site2\Application\Article\AdminArticleListView\View\ArticleDto;
use Romchik38\Site2\Application\Article\AdminArticleListView\VO\Page;

final class FilterResult
{
    /** @param array<int,ArticleDto> $list */
    public function __construct(
        public readonly SearchCriteria $searchCriteria,
        public readonly Page $page,
        public readonly array $list
    ) {
    }
}
