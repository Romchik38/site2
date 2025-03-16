<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\Sql\SearchCriteria;

use InvalidArgumentException;
use Romchik38\Server\Api\Models\SearchCriteria\LimitInterface;

class Limit implements LimitInterface
{
    public readonly string $limit;

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

    /** @todo remove */
    public function toString(): string
    {
        return $this->limit;
    }

    public function __invoke(): string
    {
        return $this->limit;
    }
}
