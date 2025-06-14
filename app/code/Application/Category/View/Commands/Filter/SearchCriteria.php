<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\View\Commands\Filter;

use Romchik38\Site2\Application\Category\View\Commands\Filter\VO\Limit;
use Romchik38\Site2\Application\Category\View\Commands\Filter\VO\Offset;
use Romchik38\Site2\Application\Category\View\Commands\Filter\VO\OrderByDirection;
use Romchik38\Site2\Application\Category\View\Commands\Filter\VO\OrderByField;

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
