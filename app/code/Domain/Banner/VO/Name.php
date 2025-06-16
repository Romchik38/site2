<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Banner\VO;

use InvalidArgumentException;

final class Name
{
    /** @throws InvalidArgumentException */
    public function __construct(
        public readonly string $name
    ) {
        if ($name === '') {
            throw new InvalidArgumentException('Banner name is empty');
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
