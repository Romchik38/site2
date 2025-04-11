<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminList;

use Romchik38\Site2\Application\Audio\AdminList\View\AudioDto;
interface RepositoryInterface
{
    /**
     * @throws RepositoryException - On invalid database data.
     * @return array<int,AudioDto>
     * */
    public function list(SearchCriteria $searchCriteria): array;

    public function totalCount(): int;
}
