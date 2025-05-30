<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminList;

use Romchik38\Site2\Application\Author\AdminList\View\AuthorDto;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException - On invalid database data.
     * @return array<int,AuthorDto>
     * */
    public function list(SearchCriteria $searchCriteria): array;

    public function totalCount(): int;
}
