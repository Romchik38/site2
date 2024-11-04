<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\Sql\SearchCriteria;

use Romchik38\Server\Api\Models\SearchCriteria\FilterInterface;

abstract class Filter implements FilterInterface
{
    protected function __construct(
        protected readonly string $expression,
        protected readonly string $param
    ) {}

    public function getExpression(string $counter = ''): string
    {
        return $this->expression . $counter;
    }

    public function getParam(): string
    {
        return $this->param;
    }
}
