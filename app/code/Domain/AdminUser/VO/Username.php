<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser\VO;

use InvalidArgumentException;

use function preg_match;
use function strlen;

final class Username
{
    public const FIELD         = 'user_name';
    public const PATTERN       = '[A-Za-z0-9_]{3,20}$';
    public const ERROR_MESSAGE = 'Username must be 3-20 characters long, can contain lowercase, uppercase letter, number and underscore. Case-Sensitive';

    /** @throws InvalidArgumentExceptions */
    public function __construct(
        public readonly string $username
    ) {
        if (strlen($username) === 0) {
            throw new InvalidArgumentException('username is empty');
        }

        $check = preg_match('/' . $this::PATTERN . '/', $username);
        if ($check === 0 || $check === false) {
            throw new InvalidArgumentException('Check field: ' . $this::ERROR_MESSAGE);
        }
    }

    public function __invoke(): string
    {
        return $this->username;
    }
}
