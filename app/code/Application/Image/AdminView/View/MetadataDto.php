<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView\View;

use function round;
use function sprintf;

final class MetadataDto
{
    public function __construct(
        public readonly int $width,
        public readonly int $height,
        public readonly string $type,
        public readonly int $bytes
    ) {
    }

    public function prettySize(): string
    {
        $str = (string) $this->bytes;
        if ($this->bytes > 1000 && $this->bytes < 1000000) {
            // kb
            $str = sprintf(
                '%s KB',
                (string) ((int) ($this->bytes / 1000))
            );
        } else {
            // mb
            $str = sprintf(
                '%s MB',
                (string) (round(
                    $this->bytes / 1000000,
                    2
                ))
            );
        }
        return $str;
    }
}
