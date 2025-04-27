<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminList;

use Romchik38\Site2\Application\Article\AdminList\Commands\Filter\SearchCriteria;
use Romchik38\Site2\Application\Article\AdminList\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\AdminList\View\ArticleDto;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException
     * @return array<int,ArticleDto>
     * */
    public function list(SearchCriteria $searchCriteria): array;

    /** @throws RepositoryException */
    public function totalCount(): int;
}
