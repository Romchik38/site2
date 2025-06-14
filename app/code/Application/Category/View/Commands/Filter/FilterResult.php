<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\View\Commands\Filter;

use Romchik38\Site2\Application\Category\View\View\ArticleDTO;
use Romchik38\Site2\Application\Category\View\Commands\Filter\VO\Page;

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
