<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\AdminList;

use Romchik38\Site2\Application\Category\AdminList\View\CategoryDto;
use Romchik38\Site2\Application\Category\AdminList\VO\Page;

final class FilterResult
{
    /** @param array<int,CategoryDto> $list */
    public function __construct(
        public readonly SearchCriteria $searchCriteria,
        public readonly Page $page,
        public readonly array $list
    ) {
    }
}
