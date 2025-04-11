<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminList;

use Romchik38\Site2\Application\Audio\AdminList\View\AudioDto;
use Romchik38\Site2\Application\Audio\AdminList\VO\Page;

final class FilterResult
{
    /** @param array<int,AudioDto> $list */
    public function __construct(
        public readonly SearchCriteria $searchCriteria,
        public readonly Page $page,
        public readonly array $list
    ) {
    }
}
