<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImgConverter\View;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class AspectRatio
{
    protected const ALLOWED_VALUES = [1, 0.67];

    protected function __construct(
        protected readonly float $aspectRatio
    ) {}

    public static function fromString(string $aspectRatio): self
    {
        $value = floatval($aspectRatio);
        if (! in_array($value, self::ALLOWED_VALUES)) {
            throw new InvalidArgumentException('param aspect ratio is invalid');
        }
        return new self($value);
    }

    public function asFloat(): float
    {
        return $this->aspectRatio;
    }

    public function asString(): string
    {
        return (string)$this->aspectRatio;
    }
}
