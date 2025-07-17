<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Number\Number;

use function sprintf;

final class Views extends Number
{
    public const NAME = 'Article views';

    /** @throws InvalidArgumentException */
    public function __construct(
        int $value
    ) {
        if ($value < 0) {
            throw new InvalidArgumentException(sprintf('param %s is less than 0', self::NAME));
        }
        parent::__construct($value);
    }
}
