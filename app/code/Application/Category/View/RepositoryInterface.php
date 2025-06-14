<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\View;

use Romchik38\Site2\Application\Category\View\Commands\Filter\SearchCriteria;
use Romchik38\Site2\Application\Category\View\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Category\View\View\CategoryDto;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException
     */
    public function find(SearchCriteria $searchCriteria): CategoryDto;
}
