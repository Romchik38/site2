<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\VO;

use InvalidArgumentException;

use function in_array;

final class Type
{
    /** All images must be only these types */
    public const ALLOWED_TYPES = ['webp'];

    public function __construct(
        private readonly string $type
    ) {
        if (! in_array($type, self::ALLOWED_TYPES)) {
            throw new InvalidArgumentException('param image type is invalid');
        }
    }

    public function __invoke(): string
    {
        return $this->type;
    }

    public function __toString(): string
    {
        return $this->type;
    }
}
