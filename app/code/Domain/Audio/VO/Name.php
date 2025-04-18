<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio\VO;

use InvalidArgumentException;

use function strlen;

final class Name
{
    /** @throws InvalidArgumentException */
    public function __construct(
        protected readonly string $name
    ) {
        if (strlen($name) === 0) {
            throw new InvalidArgumentException('param audio name is empty');
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
