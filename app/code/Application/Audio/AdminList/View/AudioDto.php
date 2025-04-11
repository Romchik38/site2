<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminList\View;

use Romchik38\Site2\Domain\Audio\VO\Id;
use Romchik38\Site2\Domain\Audio\VO\Name;
use Romchik38\Site2\Domain\Audio\VO\Size;
use Romchik38\Site2\Domain\Audio\VO\Type;

final class AudioDto
{
    public function __construct(
        public readonly Id $id,
        public readonly Name $name,
        public readonly Size $size,
        public readonly Type $tame,
    ) {
    }
}
