<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\VO;

use InvalidArgumentException;

final class Name
{
    protected function __construct(
        protected readonly string $name
    ) {}

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
}
