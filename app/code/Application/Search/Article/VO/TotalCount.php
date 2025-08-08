<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\Article\VO;

use Romchik38\Server\Domain\VO\Number\NonNegative;

final class TotalCount extends NonNegative
{
    public const NAME = 'search total count';
}
