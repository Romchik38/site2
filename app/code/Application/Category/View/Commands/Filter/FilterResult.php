<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\View\Commands\Filter;

use Romchik38\Site2\Application\Category\View\Commands\Filter\VO\Page;
use Romchik38\Site2\Application\Category\View\View\CategoryDto;

final class FilterResult
{
    public function __construct(
        public readonly SearchCriteria $searchCriteria,
        public readonly Page $page,
        public readonly CategoryDto $category
    ) {
    }
}
