<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\Sql\SearchCriteria;

use Romchik38\Server\Api\Models\SearchCriteria\LimitInterface;
use Romchik38\Server\Models\Errors\InvalidArgumentException;

/** @todo implement this */
class Limit implements LimitInterface
{
    protected readonly string $limit;

    public function __construct(
        string $limit
    ) {
        if (strtolower($limit) === 'all') {
            $this->limit = $limit;
        } else {
            $intLimit = (int)$limit;

            if ($intLimit < 0) {
                throw new InvalidArgumentException(
                    sprintf('param limit is invalid: %s', $limit)
                );
            }
            $this->limit = (string)$intLimit;
        }
    }

    public function toString(): string
    {
        return $this->limit;
    }
}
