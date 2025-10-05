<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImgConverter\View;

use InvalidArgumentException;

use function in_array;
use function is_numeric;

final class Height
{
    public const ALLOWED_VALUES = [100, 150, 300, 384, 480, 576, 720, 768, 1080];

    private function __construct(
        private readonly int $height
    ) {
    }

    public static function fromString(string $height): self
    {
        $value = (int) $height;

        if (
            ! is_numeric($height)
            || ! in_array($value, self::ALLOWED_VALUES)
        ) {
            throw new InvalidArgumentException('param height is invalid');
        }

        return new self($value);
    }

    public function __invoke(): int
    {
        return $this->height;
    }
}
