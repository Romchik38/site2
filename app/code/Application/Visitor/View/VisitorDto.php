<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Visitor\View;

use Romchik38\Site2\Domain\User\VO\Username;

final class VisitorDto
{
    public function __construct(
        public readonly ?Username $username,
        public readonly bool $isAcceptedTerms
    ) {
    }
}
