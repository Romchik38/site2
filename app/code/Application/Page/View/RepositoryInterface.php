<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\View;

use Romchik38\Site2\Application\Page\View\Commands\Find\SearchCriteria;
use Romchik38\Site2\Application\Page\View\View\PageDto;

interface RepositoryInterface
{
    /**
     * @throws NoSuchPageException
     * @throws RepositoryException - On invalid database data.
     * */
    public function find(SearchCriteria $searchCriteria): PageDto;
}
