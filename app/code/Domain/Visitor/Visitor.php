<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Visitor;

use Romchik38\Site2\Domain\User\VO\Username;
use Romchik38\Site2\Domain\Visitor\VO\CsrfToken;

final class Visitor
{
    public function __construct(
        public ?Username $username,
        private(set) bool $isAcceptedTerms,
        public CsrfToken $csrfTocken
    ) {
    }

    public function acceptWithTerms(): void
    {
        $this->isAcceptedTerms = true;
    }
}
