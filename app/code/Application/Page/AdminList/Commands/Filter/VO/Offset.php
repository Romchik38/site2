<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\AdminList\Commands\Filter\VO;

use Romchik38\Server\Domain\VO\Number\NonNegative;

final class Offset extends NonNegative
{
    public const NAME = 'page offset';
}
