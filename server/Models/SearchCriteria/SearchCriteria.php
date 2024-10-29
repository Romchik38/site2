<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\SearchCriteria;

use Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaInterface;
use Romchik38\Server\Models\Errors\InvalidArgumentException;

/** 
 * Must be extended by concrete criteria
 */
abstract class SearchCriteria implements SearchCriteriaInterface
{
    protected array $orderBy = [];

    public function __construct(
        protected string $limit = 'all',
        protected string $offset = '0'
    ) {}

    public function setOrderBy(string $field): self
    {
        if (strlen($field) === 0) {
            throw new InvalidArgumentException('field prop can\'t be empty');
        }
        $this->orderBy[] = $field;
        return $this;
    }

    public function setLimit(string $limit): self
    {
        if ($limit === 'all') {
            $this->limit = $limit;
            return $this;
        }

        $limit = (int)$limit;

        if ($limit >= 0) {
            $this->limit = $limit;
            return $this;
        }

        throw new InvalidArgumentException(
            sprintf('param limit is invalid: %s', $limit)
        );
    }

    public function setOffset(string $offset): self
    {
        $offset = (int)$offset;

        if ($offset >= 0) {
            $this->offset = $offset;
            return $this;
        }

        throw new InvalidArgumentException(
            sprintf('param offset is invalid: %s', $offset)
        );
    }
}
