<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Filesystem\Image;

use InvalidArgumentException;

use function explode;

class Image
{
    public readonly int $width;
    public readonly int $height;
    public readonly string $type;

    /**
     * @param array<int|string,mixed> $dimensions
     * @throws InvalidArgumentException
     * */
    public function __construct(
        array $dimensions,
        public readonly int $size
    ) {
        $originalWidth = $dimensions[0];
        if ($originalWidth === 0) {
            throw new InvalidArgumentException('Cannot determine image width size');
        }
        $this->width  = $originalWidth;
        $this->height = $dimensions[1];

        $mime = $dimensions['mime'] ?? null;
        if ($mime === null) {
            throw new InvalidArgumentException('Cannot determine image width size');
        }
        $this->type = (explode('/', $mime))[1];
    }
}
