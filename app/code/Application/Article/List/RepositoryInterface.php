<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\List;

use Romchik38\Site2\Application\Article\List\Commands\Filter\ArticleDTO;
use Romchik38\Site2\Application\Article\List\Commands\Filter\SearchCriteria;
use Romchik38\Site2\Application\Article\List\Exceptions\RepositoryException;

interface RepositoryInterface
{
    /**
     * List active article by language
     *
     * @throws RepositoryException
     * @return array<int,ArticleDTO>
     */
    public function list(SearchCriteria $searchCriteria): array;

    /**
     * count of all active article
     *
     * @throws RepositoryException
     * */
    public function totalCount(): int;
}
