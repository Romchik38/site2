<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\List\Commands\Pagination;

use Romchik38\Server\Models\Sql\SearchCriteria\Limit;
use Romchik38\Server\Models\Sql\SearchCriteria\Offset;
use Romchik38\Server\Models\Sql\SearchCriteria\OrderBy;

interface SearchCriteriaInterface
{
    public function offset(): Offset;

    public function limit(): Limit;

    public function orderBy(): OrderBy;

    public function language(): string;
}
