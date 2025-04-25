<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\VO;

use InvalidArgumentException;

use function strlen;

final class Path
{
    /** @throws InvalidArgumentException */
    public function __construct(
        protected readonly string $path
    ) {
        if (strlen($path) === 0) {
            throw new InvalidArgumentException('param image path is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->path;
    }

    public function __toString(): string
    {
        return $this->path;
    }
}
