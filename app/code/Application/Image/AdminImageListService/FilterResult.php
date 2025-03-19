<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminImageListService;

use Romchik38\Site2\Application\Image\AdminImageListService\VO\Page;

final class FilterResult
{
    public function __construct(
        public readonly SearchCriteria $searchCriteria,
        public readonly Page $page,
        public readonly array $list
    ) {
    }
}
