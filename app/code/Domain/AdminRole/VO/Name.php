<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminRole\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Text\NonEmpty;

use function in_array;
use function sprintf;

final class Name extends NonEmpty
{
    public const ERROR_ROLE_NAME_INVALID = 'Role name %s is invalid';
    public const ALLOWED_ROLES           = ['ADMIN_ROOT', 'ADMIN_LOGIN'];

    /** @throws InvalidArgumentException */
    public function __construct(
        string $value
    ) {
        if (! in_array($value, self::ALLOWED_ROLES)) {
            throw new InvalidArgumentException(sprintf(
                self::ERROR_ROLE_NAME_INVALID,
                $value
            ));
        }
        parent::__construct($value);
    }
}
