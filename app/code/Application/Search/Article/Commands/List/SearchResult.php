<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\Article\Commands\List;

use Romchik38\Site2\Application\Search\Article\View\ArticleDto;
use Romchik38\Site2\Application\Search\Article\VO\TotalCount;

final class SearchResult
{
    /**
     * @param array<int,ArticleDto> $articles
     */
    public function __construct(
        public readonly array $articles,
        public readonly TotalCount $totalCount
    ) {
    }
}
