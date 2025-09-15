<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\AdminVisitor\View;

use Romchik38\Site2\Domain\AdminUser\VO\Username;
use Romchik38\Site2\Domain\AdminVisitor\VO\CsrfToken;
use Romchik38\Site2\Domain\AdminVisitor\VO\Message;

final readonly class VisitorDto
{
    public const USERNAME_FIELD   = 'username';
    public const CSRF_TOKEN_FIELD = 'csrf_token';

    public function __construct(
        public ?Username $username,
        public CsrfToken $csrfToken,
        public ?Message $message
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

    public function getMessage(): ?string
    {
        if ($this->message === null) {
            return $this->message;
        } else {
            return (string) $this->message;
        }
    }
}
