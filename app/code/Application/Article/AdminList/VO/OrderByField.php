<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminList\VO;

use InvalidArgumentException;

use function in_array;
use function sprintf;

final class OrderByField
{
    public const DEFAULT_ORDER_BY = 'created_at';
    public const ALLOWED_ORDER_BY = ['identifier', 'active', 'created_at'];

    public readonly string $orderByField;

    public function __construct(
        string $orderByField,
    ) {
        if ($orderByField === '') {
            $this->orderByField = $this::DEFAULT_ORDER_BY;
        } else {
            if (in_array($orderByField, $this::ALLOWED_ORDER_BY) === false) {
                throw new InvalidArgumentException(
                    sprintf('param order by field %s is invalid', $orderByField)
                );
            }
            $this->orderByField = $orderByField;
        }
    }

    public function __invoke(): string
    {
        return $this->orderByField;
    }
}
