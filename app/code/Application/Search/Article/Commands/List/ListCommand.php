<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\Article\Commands\List;

final class ListCommand
{
    public const QUERY_FILED = 'query';

    public function __construct(
        public readonly string $query,
        public readonly string $language
    ) {
    }
}
