<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\VO;

use InvalidArgumentException;

final class Id
{
    public function __construct(
        protected readonly int $id
    ) {
        if ($id <= 0) {
            throw new InvalidArgumentException('param image id must be greater than 0');
        }
    }

    public function __invoke(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public static function fromString(string $id): self
    {
        $oldValue = $id;
        $intId = (int) $id;
        $strId = (string) $intId;
        if ($oldValue !== $strId) {
            throw new InvalidArgumentException(sprintf(
                'param image id %s is invalid',
                $id
            ));
        } 

        return new self($intId);
    }
}
