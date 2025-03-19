<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\User\VO;

use InvalidArgumentException;

use function preg_match;
use function strlen;

final class Email
{
    public const FIELD         = 'email';
    public const PATTERN       = '^[A-Za-z0-9.]{2,}@[A-Za-z0-9.]{2,}\.[a-z]{2,}$';
    public const ERROR_MESSAGE = 'Email Local Part can contain latin '
        . 'characters, numbers and a dot. Domain can contain latin characters'
        . ' and a dot, must end minimun with 2 characters after a dot';

    /** @throws InvalidArgumentException */
    public function __construct(
        public readonly string $email
    ) {
        if (strlen($email) === 0) {
            throw new InvalidArgumentException('email is empty');
        }

        $check = preg_match('/' . $this::PATTERN . '/', $email);
        if ($check === 0 || $check === false) {
            throw new InvalidArgumentException($this::ERROR_MESSAGE);
        }
    }

    public function __invoke(): string
    {
        return $this->email;
    }
}
