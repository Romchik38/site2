<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminRole\VO;

use InvalidArgumentException;

use function in_array;
use function sprintf;

final class Name
{
    public const ERROR_ROLE_NAME_INVALID = 'Role name %s is invalid';
    public const ALLOWED_ROLES           = ['ADMIN_ROOT', 'ADMIN_LOGIN'];

    /** @throws InvalidArgumentException */
    public function __construct(
        protected readonly string $name
    ) {
        if (! in_array($name, self::ALLOWED_ROLES)) {
            throw new InvalidArgumentException(sprintf(
                self::ERROR_ROLE_NAME_INVALID,
                $name
            ));
        }
    }

    public function __invoke(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
