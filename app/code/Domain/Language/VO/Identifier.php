<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Language\VO;

use InvalidArgumentException;

use function strlen;

final class Identifier
{
    /** @throws InvalidArgumentException */
    public function __construct(
        protected readonly string $id
    ) {
        if (strlen($id) === 0) {
            throw new InvalidArgumentException('param id is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
