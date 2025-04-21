<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Category\VO;

use InvalidArgumentException;

use function sprintf;

final class Identifier
{
    public const NAME = 'Category_Identifier';

    /** @throws InvalidArgumentException */
    public function __construct(
        private readonly string $id
    ) {
        if ($id === '') {
            throw new InvalidArgumentException(
                sprintf('%s %s is invalid', $this::NAME, $id)
            );
        }
    }

    public function __invoke(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
