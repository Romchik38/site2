<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\VO;

use InvalidArgumentException;

use function strlen;

final class Name
{
    public function __construct(
        protected readonly string $name
    ) {
        if (strlen($name) === 0) {
            throw new InvalidArgumentException('param name is empty');
        }
    }

    /** @todo remove as duplicate of __construct */
    public static function fromString(string $name): self
    {
        if (strlen($name) === 0) {
            throw new InvalidArgumentException('param name is empty');
        }
        return new self($name);
    }

    public function __invoke(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
