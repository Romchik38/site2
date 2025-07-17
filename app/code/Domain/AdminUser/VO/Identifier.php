<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser\VO;

use Romchik38\Server\Domain\VO\Number\Positive;

final class Identifier extends Positive
{
    public const NAME = 'Admin user id';
}
