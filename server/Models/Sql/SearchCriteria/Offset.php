<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\Sql\SearchCriteria;

use Romchik38\Server\Api\Models\SearchCriteria\OffsetInterface;

class Offset implements OffsetInterface
{
    protected readonly string $offset;

    public function __construct(
        string $offset
    ) {
        $this->offset = (string)((int)$offset);
    }

    public function toString(): string
    {
        return $this->offset;
    }
}
