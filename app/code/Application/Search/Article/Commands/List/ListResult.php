<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\Article\Commands\List;

use Romchik38\Site2\Application\Search\Article\VO\Page;

final class ListResult
{
    public function __construct(
        public readonly SearchResult $searchResult,
        public readonly Page $page
    ) {        
    }
}