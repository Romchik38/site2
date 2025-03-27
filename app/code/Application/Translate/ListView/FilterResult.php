<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\ListView;

use Romchik38\Site2\Application\Translate\ListView\View\TranslateDto;
use Romchik38\Site2\Application\Translate\ListView\VO\Page;

final class FilterResult
{
    /** @param array<int,TranslateDto> $list */
    public function __construct(
        public readonly SearchCriteria $searchCriteria,
        public readonly Page $page,
        public readonly array $list
    ) {
    }
}
