<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\List;

use Romchik38\Site2\Application\Article\List\Commands\Pagination\ArticleDTO;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\SearchCriteriaInterface;

interface RepositoryInterface
{
    /** list active article by language
     *
     * @return array<int,ArticleDTO>
     */
    public function list(SearchCriteriaInterface $searchCriteria): array;

    /** count of all active article */
    public function totalCount(): int;
}
