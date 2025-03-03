<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImgConverter\View;

use InvalidArgumentException;

final class Height
{
    protected const ALLOWED_VALUES = [100, 384, 480, 576, 720, 768, 1080];

    protected function __construct(
        protected readonly int $height
    ) {}

    public static function fromString(string $height): self
    {
        $value = (int)$height;

        if (
            !is_numeric($height)
            || !in_array($value, self::ALLOWED_VALUES)
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
