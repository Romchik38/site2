<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImgConverter\View;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class Size
{
    protected const ALLOWED_VALUES = [576, 720, 768, 1080];

    protected function __construct(
        protected readonly int $size
    ) {}

    public static function fromString(string $size): self
    {
        $value = (int)$size;

        if (
            !is_numeric($size)
            || !in_array($value, self::ALLOWED_VALUES)
        ) {
            throw new InvalidArgumentException('param size is invalid');
        }


        return new self($value);
    }

    public function __invoke(): int
    {
        return $this->size;
    }
}
