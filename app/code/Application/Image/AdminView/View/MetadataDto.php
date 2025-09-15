<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView\View;

use function round;
use function sprintf;

final readonly class MetadataDto
{
    public function __construct(
        public int $width,
        public int $height,
        public string $type,
        public int $bytes
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
