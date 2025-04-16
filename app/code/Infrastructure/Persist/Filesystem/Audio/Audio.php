<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Filesystem\Audio;

use InvalidArgumentException;

class Audio
{
    /** @throws InvalidArgumentException */
    public function __construct(
        public readonly string $type,
        public readonly int $size
    ) {
        if ($type === '') {
            throw new InvalidArgumentException('Audio type is empty');
        }

        if ($size <= 0) {
            throw new InvalidArgumentException('Audio size must be greater than 0');
        }
    }
}
