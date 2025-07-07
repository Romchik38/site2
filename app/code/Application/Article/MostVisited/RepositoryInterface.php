<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\MostVisited;

use Romchik38\Site2\Application\Article\MostVisited\Commands\List\SearchCriteria;
use Romchik38\Site2\Application\Article\MostVisited\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\MostVisited\Views\ArticleDTO;

interface RepositoryInterface
{
    /**
     * List most visited active article
     *
     * @throws RepositoryException
     * @return array<int,ArticleDTO>
     */
    public function list(SearchCriteria $searchCriteria): array;
}
