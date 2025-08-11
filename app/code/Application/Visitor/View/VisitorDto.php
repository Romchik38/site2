<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Visitor\View;

use Romchik38\Site2\Domain\User\VO\Username;
use Romchik38\Site2\Domain\Visitor\VO\CsrfToken;
use Romchik38\Site2\Domain\Visitor\VO\Message;

final class VisitorDto
{
    public const USERNAME_FIELD       = 'username';
    public const ACCEPTED_TERMS_FIELD = 'accepted_terms';
    public const CSRF_TOKEN_FIELD     = 'csrf_token';

    public function __construct(
        public readonly ?Username $username,
        public readonly bool $isAcceptedTerms,
        public readonly CsrfToken $csrfToken,
        public readonly ?Message $message
    ) {
    }

    public function getUserName(): ?string
    {
        if ($this->username === null) {
            return $this->username;
        } else {
            return (string) $this->username;
        }
    }

    public function getCsrfToken(): string
    {
        return (string) $this->csrfToken;
    }

    public function getCsrfTokenField(): string
    {
        return $this::CSRF_TOKEN_FIELD;
    }

    public function getIsAcceptedTerms(): int
    {
        if ($this->isAcceptedTerms) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getMessage(): ?string
    {
        if ($this->message === null) {
            return $this->message;
        } else {
            return (string) $this->message;
        }
    }
}
