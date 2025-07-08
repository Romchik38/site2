<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminMostVisited;

use Romchik38\Site2\Application\Article\AdminMostVisited\Commands\List\SearchCriteria;
use Romchik38\Site2\Application\Article\AdminMostVisited\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\AdminMostVisited\Views\ArticleDTO;

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
