<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\Article;

use Romchik38\Site2\Application\Search\Article\Commands\List\SearchCriteria;
use Romchik38\Site2\Application\Search\Article\View\ArticleDto;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException
     * @return array<int,ArticleDto>
     * */
    public function list(SearchCriteria $searchCriteria): array;
}
