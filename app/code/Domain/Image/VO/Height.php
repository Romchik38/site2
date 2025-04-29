<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\VO;

use InvalidArgumentException;

use function sprintf;

final class Height
{
    public const MIN_VALUE = 1085;

    /** @throws InvalidArgumentException */
    public function __construct(
        private readonly int $height
    ) {
        if ($height < 1085) {
            throw new InvalidArgumentException(sprintf(
                'param image height %s is too small, min is %s',
                $height,
                (string) self::MIN_VALUE
            ));
        }
    }

    /** @throws InvalidArgumentException */
    public static function fromString(string $height): self
    {
        $intValue = (int) $height;
        $strValue = (string) $intValue;

        if ($height !== $strValue) {
            throw new InvalidArgumentException('param height is invalid');
        }

        return new self($intValue);
    }

    public function __invoke(): int
    {
        return $this->height;
    }

    public function __toString(): string
    {
        return (string) $this->height;
    }
}
