<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminArticleListView;

use Romchik38\Site2\Application\Article\AdminArticleListView\View\ArticleDto;

interface RepositoryInterface
{
    /** 
     * @throws RepositoryException - On invalid database data
     * @return array<int,ArticleDto> 
     * */
    public function list(SearchCriteria $searchCriteria): array;
}