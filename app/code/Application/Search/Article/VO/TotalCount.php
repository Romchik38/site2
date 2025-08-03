<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\Article\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Number\Number;

use function sprintf;

final class TotalCount extends Number
{
    public const NAME = 'search total count';

    public function __construct(
        int $value
    ) {
        if ($value < 0) {
            throw new InvalidArgumentException(sprintf('param %s is negative', $this::NAME));
        }
        parent::__construct($value);
    }
}
