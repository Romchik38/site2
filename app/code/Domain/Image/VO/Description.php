<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\VO;

use InvalidArgumentException;

final class Description
{
    protected function __construct(
        protected readonly string $description
    ) {}

    public static function fromString(string $description): self
    {
        if (strlen($description) === 0) {
            throw new InvalidArgumentException('param description is empty');
        }
        return new self($description);
    }

    public function __invoke(): string
    {
        return $this->description;
    }
}
