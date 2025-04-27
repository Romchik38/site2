<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\List\Commands\Pagination;

use Romchik38\Site2\Application\Article\List\Commands\Pagination\ArticleDTO;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\VO\Page;

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
