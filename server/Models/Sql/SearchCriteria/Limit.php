<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\Sql\SearchCriteria;

use Romchik38\Server\Api\Models\SearchCriteria\LimitInterface;
use Romchik38\Server\Models\Errors\InvalidArgumentException;

/** @todo implement this */
class Limit implements LimitInterface
{
    public function __construct(
        protected readonly string $limit = 'all',
    ) {
        $limit = (int)$limit;

        if ($limit < 0) {
            throw new InvalidArgumentException(
                sprintf('param limit is invalid: %s', $limit)
            );
        }
    }

    public function toString(): string {
        return $this->limit;
    }
}
