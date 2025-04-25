<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Translate\VO;

use InvalidArgumentException;

final class Phrase
{
    /** @throws InvalidArgumentException */
    public function __construct(
        public readonly string $phrase
    ) {
        if ($phrase === '') {
            throw new InvalidArgumentException('Translate phrase is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->phrase;
    }

    public function __toString(): string
    {
        return $this->phrase;
    }
}
