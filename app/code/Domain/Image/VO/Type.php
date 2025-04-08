<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\VO;

use InvalidArgumentException;

use function in_array;
use function sprintf;

final class Type
{
    /** All images must be only these types */
    public const ALLOWED_TYPES = ['webp'];

    /** @throws InvalidArgumentException */
    public function __construct(
        private readonly string $type
    ) {
        if (! in_array($type, self::ALLOWED_TYPES)) {
            throw new InvalidArgumentException(sprintf(
                'param image type %s is invalid',
                $type
            ));
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
