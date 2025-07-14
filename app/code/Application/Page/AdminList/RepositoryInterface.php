<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\AdminList;

use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\SearchCriteria;
use Romchik38\Site2\Application\Page\AdminList\View\PageDto;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException - On invalid database data.
     * @return array<int,PageDto>
     * */
    public function filter(SearchCriteria $searchCriteria): array;

    /** @throws RepositoryException */
    public function totalCount(): int;
}
