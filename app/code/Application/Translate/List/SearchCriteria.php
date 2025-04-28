<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\List;

use Romchik38\Site2\Application\Translate\List\VO\Limit;
use Romchik38\Site2\Application\Translate\List\VO\Offset;
use Romchik38\Site2\Application\Translate\List\VO\OrderByDirection;
use Romchik38\Site2\Application\Translate\List\VO\OrderByField;

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
