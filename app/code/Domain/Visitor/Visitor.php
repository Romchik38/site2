<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Visitor;

use Romchik38\Site2\Domain\User\VO\Username;
use Romchik38\Site2\Domain\Visitor\VO\CsrfToken;
use Romchik38\Site2\Domain\Visitor\VO\Message;

final class Visitor
{
    public function __construct(
        public CsrfToken $csrfTocken,
        public ?Username $username = null,
        private(set) bool $isAcceptedTerms = false,
        public ?Message $message = null
    ) {
    }

    public function acceptWithTerms(): void
    {
        $this->isAcceptedTerms = true;
    }
}
