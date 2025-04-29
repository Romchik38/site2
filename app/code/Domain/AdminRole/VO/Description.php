<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminRole\VO;

use InvalidArgumentException;

final class Description
{
    /** @throws InvalidArgumentException */
    public function __construct(
        private readonly string $description
    ) {
        if ($description === '') {
            throw new InvalidArgumentException('Role description is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->description;
    }
}
