<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser\VO;

use InvalidArgumentException;

final class Identifier
{
    /** @throws InvalidArgumentException */
    public function __construct(
        public readonly int $identifier
    ) {
        if ($identifier === 0) {
            throw new InvalidArgumentException('identifier is invalid');
        }
    }

    public function __invoke(): int
    {
        return $this->identifier;
    }
}
