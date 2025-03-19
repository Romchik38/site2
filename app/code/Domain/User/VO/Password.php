<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\User\VO;

use InvalidArgumentException;

use function preg_match;
use function strlen;

final class Password
{
    public const FIELD         = 'password';
    public const PATTERN       = '^(?=.*[_`$%^*\'])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[A-Za-z0-9_`$%^*\']{8,}$';
    public const ERROR_MESSAGE = 'Password must be at least 8 characters long'
        . ', contain at least one lowercase, uppercase letter, number and a '
        . 'specal character from _`$%^*\'';

    /** @throws InvalidArgumentExceptions */
    public function __construct(
        public readonly string $password
    ) {
        if (strlen($password) === 0) {
            throw new InvalidArgumentException('param password is empty');
        }

        $check = preg_match('/' . $this::PATTERN . '/', $password);
        if ($check === 0 || $check === false) {
            throw new InvalidArgumentException($this::ERROR_MESSAGE);
        }
    }

    public function __invoke(): string
    {
        return $this->password;
    }
}
