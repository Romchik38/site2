<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminArticleListView\View;

use Romchik38\Site2\Application\Article\AdminArticleListView\View\ArticleDto;

interface RepositoryInterface
{
    /** @return array<int,ArticleDto> */
    public function list(SearchCriteriaInterface $searchCriteria): array;
}