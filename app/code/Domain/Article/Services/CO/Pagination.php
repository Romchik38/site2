<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\Services\CO;

final class Pagination
{
    public function __construct(
        protected string $limit,
        protected string $offset
    ) {}

    public function limit(): string
    {
        return $this->limit;
    }

    public function offset(): string
    {
        return $this->offset;
    }
}
