<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\VO;

use InvalidArgumentException;

final class Size
{
    public const MAX_VALUE = 2097152;

    /** 
     * @param int $size - Content size in bytes
     * */
    public function __construct(
        protected readonly int $size
    ) {
        if ($size > self::MAX_VALUE) {
            throw new InvalidArgumentException(sprintf(
                'param image size %s is too big, max is %s',
                $size,
                (string) self::MAX_VALUE
            ));
        }

        if ($size < 1 ) {
            throw new InvalidArgumentException(sprintf(
                'param image size %s is invalid',
                $size,
            ));
        }
    }

    public static function fromString(string $size): self
    {
        $intValue = (int) $size;
        $strValue = (string) $intValue;

        if ($size !== $strValue) {
            throw new InvalidArgumentException('param size is invalid');
        }

        return new self($intValue);
    }

    public function __invoke(): int
    {
        return $this->size;
    }

    public function __toString(): string
    {
        return (string) $this->size;
    }
}
