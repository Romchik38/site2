<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminAuthorList;

use Romchik38\Site2\Application\Author\AdminAuthorList\VO\Page;

final class FilterResult
{
    /** @param array<int,ImageDto> $list */
    public function __construct(
        public readonly SearchCriteria $searchCriteria,
        public readonly Page $page,
        public readonly array $list
    ) {
    }
}
