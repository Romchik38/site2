<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\Article\Commands\List;

use Romchik38\Site2\Application\Search\Article\VO\Limit;
use Romchik38\Site2\Application\Search\Article\VO\Page;
use Romchik38\Site2\Application\Search\Article\VO\Query;

final class ListResult
{
    public function __construct(
        public readonly SearchResult $searchResult,
        public readonly Page $page,
        public readonly Query $query,
        public readonly Limit $limit
    ) {
    }
}
