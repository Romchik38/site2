<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Number\Positive;

use function sprintf;

final class Size extends Positive
{
    public const NAME      = 'Audio size';
    public const MAX_VALUE = 2097152;

    /**
     * @param int $value - Content size in bytes
     * @throws InvalidArgumentException
     * */
    public function __construct(
        int $value
    ) {
        if ($value > self::MAX_VALUE) {
            throw new InvalidArgumentException(sprintf(
                'param %s %d is too big, max is %d',
                self::NAME,
                $value,
                self::MAX_VALUE
            ));
        }
        parent::__construct($value);
    }
}
