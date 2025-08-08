<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminVisitor;

use Romchik38\Site2\Domain\AdminUser\VO\Username;
use Romchik38\Site2\Domain\AdminVisitor\VO\CsrfToken;

final class AdminVisitor
{
    public function __construct(
        public ?Username $username,
        public CsrfToken $csrfTocken
    ) {
    }
}
