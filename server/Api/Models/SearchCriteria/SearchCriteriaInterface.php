<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\SearchCriteria;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

interface SearchCriteriaInterface 
{
    /** @throws InvalidArgumentException on empty field */
    public function setOrderBy(string $field): self;

    /**
     * @param string $limit can be 'all' or number greater or eq '0'
     * @throws InvalidArgumentException on limit < 0 
     * */
    public function setLimit(string $limit): self;

    /** @throws InvalidArgumentException on offset < 0 */
    public function setOffset(string $offset): self;
}
