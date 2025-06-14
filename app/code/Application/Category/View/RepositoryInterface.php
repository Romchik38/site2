<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\View;

use Romchik38\Site2\Application\Category\View\Commands\Filter\SearchCriteria;
use Romchik38\Site2\Application\Category\View\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Category\View\View\ArticleDTO;

interface RepositoryInterface
{
    /**
     * List active article by language
     *
     * @throws RepositoryException
     * @return array<int,ArticleDTO>
     */
    public function list(SearchCriteria $searchCriteria): array;

    /**
     * count of all active article
     *
     * @throws RepositoryException
     * */
    public function totalCount(): int;
}
