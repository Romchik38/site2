<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\ArticleSearch;

use Romchik38\Site2\Application\Search\ArticleSearch\Commands\List\SearchCriteria;
use Romchik38\Site2\Application\Search\ArticleSearch\View\ArticleDto;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException
     * @return array<int,ArticleDto>
     * */
    public function list(SearchCriteria $searchCriteria): array;
}
