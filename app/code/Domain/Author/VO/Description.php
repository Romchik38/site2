<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Author\VO;

use InvalidArgumentException;

final class Description
{
    public function __construct(
        public readonly string $name
    ) {
        if ($name === '') {
            throw new InvalidArgumentException('Authir Description is empty');
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
