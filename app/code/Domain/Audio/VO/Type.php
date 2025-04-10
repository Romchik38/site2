<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio\VO;

use InvalidArgumentException;

use function in_array;
use function sprintf;

final class Type
{
    /** All audio must be only these types */
    public const ALLOWED_TYPES = ['mp3'];

    /** @throws InvalidArgumentException */
    public function __construct(
        private readonly string $type
    ) {
        if (! in_array($type, self::ALLOWED_TYPES)) {
            throw new InvalidArgumentException(sprintf(
                'param audio type %s is invalid',
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
