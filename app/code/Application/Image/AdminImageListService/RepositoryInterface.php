<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminImageListService;

use Romchik38\Site2\Application\Image\AdminImageListService\View\ImageDto;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException - On invalid database data.
     * @return array<int,ImageDto>
     * */
    public function list(SearchCriteria $searchCriteria): array;

    public function totalCount(): int;
}
