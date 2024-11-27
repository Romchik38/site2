<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImgConverter\View;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class Width
{
    protected const ALLOWED_VALUES = [100, 576, 720, 768, 1080];

    protected function __construct(
        protected readonly int $width
    ) {}

    public static function fromString(string $width): self
    {
        $value = (int)$width;

        if (
            !is_numeric($width)
            || !in_array($value, self::ALLOWED_VALUES)
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
