<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\AdminList;

use Romchik38\Site2\Application\Category\AdminList\VO\Limit;
use Romchik38\Site2\Application\Category\AdminList\VO\Offset;
use Romchik38\Site2\Application\Category\AdminList\VO\OrderByDirection;
use Romchik38\Site2\Application\Category\AdminList\VO\OrderByField;

final class SearchCriteria
{
    public function __construct(
        public readonly Offset $offset,
        public readonly Limit $limit,
        public readonly OrderByField $orderByField,
        public readonly OrderByDirection $orderByDirection
    ) {
    }
}
