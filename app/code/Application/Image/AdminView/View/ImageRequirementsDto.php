<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView\View;

use function round;
use function sprintf;

final readonly class ImageRequirementsDto
{
    /** @param array<int,string> $types */
    public function __construct(
        public int $width,
        public int $height,
        public int $size,
        public array $types,
    ) {
    }

    public function prettySize(): string
    {
        $str = (string) $this->size;
        if ($this->size > 1000 && $this->size < 1000000) {
            // kb
            $str = sprintf(
                '%s KB',
                (string) ((int) ($this->size / 1000))
            );
        } else {
            // mb
            $str = sprintf(
                '%s MB',
                (string) (round(
                    $this->size / 1000000,
                    2
                ))
            );
        }
        return $str;
    }
}
