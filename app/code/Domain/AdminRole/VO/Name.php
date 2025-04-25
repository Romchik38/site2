<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminRole\VO;

use InvalidArgumentException;

final class Name
{
    /** @throws InvalidArgumentException */
    public function __construct(
        protected readonly string $name
    ) {
        if ($name === '') {
            throw new InvalidArgumentException('Role name is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->name;
    }
}
