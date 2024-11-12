<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction;

final class PaginationDTO
{
    public function __construct(
        public readonly string $output,
    ) {}

    public function __invoke(): string
    {
        
        return $this->output;
    }

    public function toString(): string {
        return $this->output;
    }

}
