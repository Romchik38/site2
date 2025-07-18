<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Number\Number;

use function sprintf;

final class Height extends Number
{
    public const NAME      = 'Image height';
    public const MIN_VALUE = 1085;

    /** @throws InvalidArgumentException */
    public function __construct(
        int $value
    ) {
        if ($value < 1085) {
            throw new InvalidArgumentException(sprintf(
                'param %s %d is too small, min is %d',
                self::NAME,
                $value,
                self::MIN_VALUE
            ));
        }
        parent::__construct($value);
    }
}
