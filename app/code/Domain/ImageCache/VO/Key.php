<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\ImageCache\VO;

use Romchik38\Server\Domain\VO\Text\NonEmpty;

final class Key extends NonEmpty
{
    public const NAME = 'Image cache key';
}
