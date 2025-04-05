<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView\View;

final class ImageRequirementsDto
{
    /** @param array<int,string> $types */
    public function __construct(
        public readonly int $width,
        public readonly int $height,
        public readonly int $size,
        public readonly array $types,
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
