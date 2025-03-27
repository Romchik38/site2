<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\ListView;

use Romchik38\Site2\Application\Translate\ListView\View\TranslateDto;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException - On invalid database data.
     * @return array<int,TranslateDto>
     * */
    public function list(SearchCriteria $searchCriteria): array;

    public function totalCount(): int;
}
