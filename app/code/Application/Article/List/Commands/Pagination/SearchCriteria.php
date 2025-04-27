<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\List\Commands\Pagination;

use Romchik38\Site2\Application\Article\List\Commands\Pagination\VO\Limit;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\VO\Offset;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\VO\OrderByDirection;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\VO\OrderByField;

final class SearchCriteria
{
    public function __construct(
        public readonly Offset $offset,
        public readonly Limit $limit,
        public readonly OrderByField $orderByField,
        public readonly OrderByDirection $orderByDirection,
        public readonly string $language
    ) {
    }
}
