<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\New\DefaultAction;

use Romchik38\Site2\Application\Image\AdminImageListService\Filter;
use Romchik38\Site2\Application\Image\AdminImageListService\VO\Limit;
use Romchik38\Site2\Application\Image\AdminImageListService\VO\OrderByDirection;
use Romchik38\Site2\Application\Image\AdminImageListService\VO\OrderByField;
use Romchik38\Site2\Application\Image\AdminImageListService\VO\Page;

final class ImageFiltersDto
{
    /** @return array<int,string> */
    public function getLimits(): array
    {
        $arr = [];
        foreach (Limit::ALLOWED_LIMITS as $limit) {
            $arr[] = (string) $limit;
        }
        return $arr;
    }

    public function getDefaultLimit(): string
    {
        return (string) Limit::DEFAULT_LIMIT;
    }

    public function getLimitFiled(): string
    {
        return Filter::LIMIT_FIELD;
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

    public function getOrderByFiled(): string
    {
        return Filter::ORDER_BY_FIELD;
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

    public function getOrderByDirectionFiled(): string
    {
        return Filter::ORDER_BY_DIRECTION_FIELD;
    }

    public function getDefaultPage(): string
    {
        return (string) Page::DEFAULT_PAGE;
    }

    public function getPageField(): string
    {
        return (string) Filter::PAGE_FIELD;
    }
}
