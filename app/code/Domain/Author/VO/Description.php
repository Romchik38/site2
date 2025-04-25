<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Author\VO;

use InvalidArgumentException;

final class Description
{
    /** @throws InvalidArgumentException */
    public function __construct(
        public readonly string $description
    ) {
        if ($description === '') {
            throw new InvalidArgumentException('Authir Description is empty');
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
