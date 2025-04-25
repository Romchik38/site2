<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\ListView;

use Romchik38\Site2\Application\Translate\ListView\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Translate\ListView\View\TranslateDto;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException - On database error.
     * @return array<int,TranslateDto>
     * */
    public function list(SearchCriteria $searchCriteria): array;

    /**
     * @throws RepositoryException - On database error.
     */
    public function totalCount(): int;
}
