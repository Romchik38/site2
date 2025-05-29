<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DynamicAction;

use Romchik38\Site2\Application\Image\AdminImageListService\VO\Limit;
use Romchik38\Site2\Application\Image\AdminImageListService\VO\OrderByDirection;
use Romchik38\Site2\Application\Image\AdminImageListService\VO\OrderByField;

final class ImageFiltersDto
{
    /** @return array<int,string> */
    public function getLimits(): array
    {
        $arr = [];
        foreach(Limit::ALLOWED_LIMITS as $limit) {
            $arr[] = (string) $limit;
        }
        return $arr;
    }

    public function getDefaultLimit(): string
    {
        return (string) Limit::DEFAULT_LIMIT;
    }

    /** @return array<int,string> */
    public function getOrderBys(): array
    {
        return OrderByField::ALLOWED_ORDER_BY;
    }

    public function getDefaultOrderBy(): string
    {
        return OrderByField::DEFAULT_ORDER_BY;
    }

    /** @return array<int,string> */
    public function getOrderByDirections(): array
    {
        return OrderByDirection::ALLOWED_ORDER_BY_DIRECTIONS;
    }

    public function getDefaultOrderByDirection(): string
    {
        return OrderByDirection::DEFAULT_ORDER_BY_DIRECTION;
    }
}
