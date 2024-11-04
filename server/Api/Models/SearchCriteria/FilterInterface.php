<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\SearchCriteria;

interface FilterInterface
{
    /** @param int $counter Number to inject into expresion. Like 1 in the "col = $1" */
    public function getExpression(string $counter = ''): string;

    /** @return string The parameter for database query placeholder */
    public function getParam(): string;
}
