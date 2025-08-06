<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Visitor;

use Romchik38\Site2\Domain\User\VO\Username;

final class Visitor
{
    public function __construct(
        public ?Username $username,
        private(set) bool $isAccepted
    ) {
    }

    public function acceptWithTerms(): void
    {
        $this->isAccepted = true;
    }
}
