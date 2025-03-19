<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminImageListService;

use Romchik38\Site2\Application\Image\AdminImageListService\VO\Limit;
use Romchik38\Site2\Application\Image\AdminImageListService\VO\Offset;
use Romchik38\Site2\Application\Image\AdminImageListService\VO\OrderByField;
use Romchik38\Site2\Application\Image\AdminImageListService\VO\OrderByDirection;

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
