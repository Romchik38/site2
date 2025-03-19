<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImgConverter\View;

use InvalidArgumentException;

use function in_array;

final class Type
{
    protected const ALLOWED_TYPES = ['webp'];

    protected function __construct(
        protected readonly string $type
    ) {
    }

    public static function fromString(string $type): self
    {
        if (! in_array($type, self::ALLOWED_TYPES)) {
            throw new InvalidArgumentException('param type has not allowed value');
        }
        return new self($type);
    }

    public function __invoke(): string
    {
        return $this->type;
    }
}
