<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\ListView\VO;

use InvalidArgumentException;

use function in_array;
use function sprintf;

final class OrderByDirection
{
    public const DEFAULT_ORDER_BY_DIRECTION  = 'desc';
    public const ALLOWED_ORDER_BY_DIRECTIONS = ['asc', 'desc'];

    public readonly string $orderByDirection;

    public function __construct(
        string $orderByDirection
    ) {
        if ($orderByDirection === '') {
            $this->orderByDirection = self::DEFAULT_ORDER_BY_DIRECTION;
        } else {
            if (in_array($orderByDirection, self::ALLOWED_ORDER_BY_DIRECTIONS) === false) {
                throw new InvalidArgumentException(
                    sprintf('param order by direction %s is invalid', $orderByDirection)
                );
            }
            $this->orderByDirection = $orderByDirection;
        }
    }

    public function __invoke(): string
    {
        return $this->orderByDirection;
    }
}
