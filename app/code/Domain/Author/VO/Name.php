<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Author\VO;

use InvalidArgumentException;

final class Name
{
    public function __construct(
        public readonly string $name
    ) {
        if ($name === '') {
            throw new InvalidArgumentException('Authir name is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->name;
    }
}
