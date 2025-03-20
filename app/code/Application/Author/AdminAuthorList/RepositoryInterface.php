<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminAuthorList;

use Romchik38\Site2\Application\Author\AdminAuthorList\View\AuthorDto;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException - On invalid database data.
     * @return array<int,AuthorDto>
     * */
    public function list(SearchCriteria $searchCriteria): array;

    public function totalCount(): int;
}
