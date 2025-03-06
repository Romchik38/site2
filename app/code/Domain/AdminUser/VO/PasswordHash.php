<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser\VO;

use InvalidArgumentException;

final class PasswordHash
{
    public function __construct(
        protected readonly string $hash
    )
    {
        if ($hash === '') {
            throw new InvalidArgumentException('Password hash is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->hash;
    }
}
