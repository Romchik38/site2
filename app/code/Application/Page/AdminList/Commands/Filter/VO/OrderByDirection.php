<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\AdminList\Commands\Filter\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Text\Text;

use function in_array;
use function sprintf;

final class OrderByDirection extends Text
{
    public const NAME = 'page order by direction';

    public const DEFAULT_ORDER_BY_DIRECTION  = 'asc';
    public const ALLOWED_ORDER_BY_DIRECTIONS = ['asc', 'desc'];

    /** @throws InvalidArgumentException */
    public function __construct(
        string $orderByDirection
    ) {
        if ($orderByDirection === '') {
            $orderByDirection = self::DEFAULT_ORDER_BY_DIRECTION;
        } else {
            if (in_array($orderByDirection, self::ALLOWED_ORDER_BY_DIRECTIONS) === false) {
                throw new InvalidArgumentException(
                    sprintf('param %s %s is invalid', $this::NAME, $orderByDirection)
                );
            }
            parent::__construct($orderByDirection);
        }
    }
}
