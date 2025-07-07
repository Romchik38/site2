<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\MostVisited\Commands\List;

use InvalidArgumentException;

use function sprintf;

final class Count
{
    public const MAX_COUNT = '10';

    /** @throws InvalidArgumentException */
    private function __construct(
        private readonly int $count
    ) {
        if ($count < 0 || $count > self::MAX_COUNT) {
            throw new InvalidArgumentException(sprintf('Param article views count is invalid %d', $count));
        }
    }

    public function __invoke(): int
    {
        return $this->count;
    }
}
