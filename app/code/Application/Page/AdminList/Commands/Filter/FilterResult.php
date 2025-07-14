<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\AdminList\Commands\Filter;

use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\VO\Page;
use Romchik38\Site2\Application\Page\AdminList\View\PageDto;

final class FilterResult
{
    /** @param array<int,PageDto> $list */
    public function __construct(
        public readonly SearchCriteria $searchCriteria,
        public readonly Page $page,
        public readonly array $list
    ) {
    }
}
