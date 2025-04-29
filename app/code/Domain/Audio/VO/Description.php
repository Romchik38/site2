<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio\VO;

use InvalidArgumentException;

use function strlen;

final class Description
{
    /** @throws InvalidArgumentException */
    public function __construct(
        private readonly string $description
    ) {
        if (strlen($description) === 0) {
            throw new InvalidArgumentException('param audio description is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->description;
    }

    public function __toString(): string
    {
        return $this->description;
    }
}
