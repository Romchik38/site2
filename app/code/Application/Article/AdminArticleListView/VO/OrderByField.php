<?php
declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminArticleListView\VO;

use InvalidArgumentException;

final class OrderByField
{
    public const DEFAULT_ORDER_BY = 'created_at';
    public const ALLOWED_ORDER_BYS = ['created_at', 'identifier'];

    public function __construct(
        public readonly string $orderByField,
    ) {
        if ($orderByField === '') {
            $this->orderByField = $this::DEFAULT_ORDER_BY;
        } else {
            if (in_array($orderByField, $this::ALLOWED_ORDER_BYS) === false) {
                throw new InvalidArgumentException(
                    sprintf('param order by field %s is invalid', $orderByField)
                );
            }
        }   
    }
}