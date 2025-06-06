<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\AdminList;

use Romchik38\Site2\Application\Category\AdminList\View\CategoryDto;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException - On invalid database data.
     * @return array<int,CategoryDto>
     * */
    public function list(SearchCriteria $searchCriteria): array;

    /** @throws RepositoryException */
    public function totalCount(): int;

    /**
     * @throws RepositoryException
     * @return array<int,CategoryDto>
     * */
    public function listAll(): array;
}
