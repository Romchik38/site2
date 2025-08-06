<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Visitor\View;

use Romchik38\Site2\Domain\User\VO\Username;

final class VisitorDto
{
    public const USERNAME_FIELD = 'username';
    public const ACCEPTED_TERMS_FIELD = 'accepted_terms';

    public function __construct(
        public readonly ?Username $username,
        public readonly bool $isAcceptedTerms
    ) {
    }
}
