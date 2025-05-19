<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\VO;

use InvalidArgumentException;

use function strlen;

final class ShortDescription
{
    /** @throws InvalidArgumentException */
    public function __construct(
        private readonly string $shortDescription
    ) {
        if (strlen($shortDescription) === 0) {
            throw new InvalidArgumentException('param short description is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->shortDescription;
    }

    public function __toString(): string
    {
        return $this->shortDescription;
    }
}
