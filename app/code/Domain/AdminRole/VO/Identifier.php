<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminRole\VO;

use InvalidArgumentException;

use function sprintf;

final class Identifier
{
    /** @throws InvalidArgumentException */
    public function __construct(
        public readonly int $id
    ) {
        if ($id <= 0) {
            throw new InvalidArgumentException('Role id is invalid');
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

    /** @throws InvalidArgumentException */
    public static function fromString(string $id): self
    {
        $oldValue = $id;
        $intId    = (int) $id;
        $strId    = (string) $intId;
        if ($oldValue !== $strId) {
            throw new InvalidArgumentException(sprintf(
                'param id %s is invalid',
                $id
            ));
        }

        return new self($intId);
    }
}
