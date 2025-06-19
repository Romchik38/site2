<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImgConverter\View;

use InvalidArgumentException;

use function in_array;
use function is_numeric;

final class Width
{
    public const ALLOWED_VALUES = [100, 200, 576, 720, 768, 1080, 1200];

    private function __construct(
        private readonly int $width
    ) {
    }

    public static function fromString(string $width): self
    {
        $value = (int) $width;

        if (
            ! is_numeric($width)
            || ! in_array($value, self::ALLOWED_VALUES)
        ) {
            throw new InvalidArgumentException('param width is invalid');
        }

        return new self($value);
    }

    public function __invoke(): int
    {
        return $this->width;
    }
}
