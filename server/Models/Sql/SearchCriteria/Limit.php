<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\Sql\SearchCriteria;

/** @todo implement this */
class Limit {
    public function __construct(
        protected readonly string $limit = 'all',
    )
    {
        $limit = (int)$limit;

        if ($limit >= 0) {
            $this->limit = $limit;
            return $this;
        }

        throw new InvalidArgumentException(
            sprintf('param limit is invalid: %s', $limit)
        );
    }
}