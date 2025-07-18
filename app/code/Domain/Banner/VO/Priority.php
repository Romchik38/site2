<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Banner\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Number\Number;

use function sprintf;

final class Priority extends Number
{
    public const NAME         = 'Banner priority';
    public const MIN_PRIORITY = 1;
    public const MAX_PRIORITY = 100;

    /** @throws InvalidArgumentException */
    public function __construct(
        int $value
    ) {
        if ($value < self::MIN_PRIORITY || $value > self::MAX_PRIORITY) {
            throw new InvalidArgumentException(sprintf('Param %s %d is invalid', self::NAME, $value));
        }
        parent::__construct($value);
    }
}
