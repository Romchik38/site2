<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\SimilarArticles\Commands\ListSimilar;

use InvalidArgumentException;

use function sprintf;

final class Count
{
    public const MAX_COUNT = '10';

    /** @throws InvalidArgumentException */
    public function __construct(
        private readonly int $count
    ) {
        if ($count <= 0 || $count > self::MAX_COUNT) {
            throw new InvalidArgumentException(sprintf('Param article similat count is invalid %d', $count));
        }
    }

    public function __invoke(): int
    {
        return $this->count;
    }

    public function __toString(): string
    {
        return (string) $this->count;
    }
}
