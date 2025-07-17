<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser\VO;

use Romchik38\Server\Domain\VO\Text\NonEmpty;

final class PasswordHash extends NonEmpty
{
    public const NAME = 'Admin user password hash';
}
