<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\VO;

use InvalidArgumentException;

use function sprintf;

final class Width
{
    public const MIN_VALUE = 1085;

    /** @throws InvalidArgumentException */
    public function __construct(
        private readonly int $width
    ) {
        if ($width < 1085) {
            throw new InvalidArgumentException(sprintf(
                'param image width %s is too small, min is %s',
                $width,
                (string) self::MIN_VALUE
            ));
        }
    }

    /** @throws InvalidArgumentException */
    public static function fromString(string $width): self
    {
        $intValue = (int) $width;
        $strValue = (string) $intValue;

        if ($width !== $strValue) {
            throw new InvalidArgumentException('param width is invalid');
        }

        return new self($intValue);
    }

    public function __invoke(): int
    {
        return $this->width;
    }

    public function __toString(): string
    {
        return (string) $this->width;
    }
}
