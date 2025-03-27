<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\ListView;

use Romchik38\Site2\Application\Translate\ListView\VO\Limit;
use Romchik38\Site2\Application\Translate\ListView\VO\Offset;
use Romchik38\Site2\Application\Translate\ListView\VO\OrderByDirection;
use Romchik38\Site2\Application\Translate\ListView\VO\OrderByField;

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
