<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminList;

use Romchik38\Site2\Application\Author\AdminList\View\AuthorDto;
use Romchik38\Site2\Application\Author\AdminList\VO\Page;

final class FilterResult
{
    /** @param array<int,AuthorDto> $list */
    public function __construct(
        public readonly SearchCriteria $searchCriteria,
        public readonly Page $page,
        public readonly array $list
    ) {
    }
}
