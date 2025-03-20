<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminImageListService\VO;

use InvalidArgumentException;

use function sprintf;

final class Offset
{
    public function __construct(
        public readonly int $offset
    ) {
        if ($offset < 0) {
            throw new InvalidArgumentException(
                sprintf('param offset %s is invalid', $offset)
            );
        }
    }

    public function __invoke(): int
    {
        return $this->offset;
    }

    public function __toString(): string
    {
        return (string) $this->offset;
    }
}
