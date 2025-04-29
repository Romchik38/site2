<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\ImageCache\VO;

use InvalidArgumentException;

use function in_array;
use function sprintf;

final class Type
{
    public const ALLOWED_TYPES = ['webp'];

    /** @throws InvalidArgumentException */
    public function __construct(
        private readonly string $type
    ) {
        if (in_array($type, self::ALLOWED_TYPES) === false) {
            throw new InvalidArgumentException(
                sprintf('param type has not allowed value %s', $type)
            );
        }
    }

    public function __invoke(): string
    {
        return $this->type;
    }
}
