<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Visitor\VO;

use Romchik38\Server\Domain\VO\Text\NonEmpty;

final class Message extends NonEmpty
{
    public const NAME = 'visitor message';
}
