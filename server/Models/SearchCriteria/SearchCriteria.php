<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\SearchCriteria;

use Romchik38\Server\Api\Models\SearchCriteria\OrderByInterface;
use Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaInterface;
use Romchik38\Server\Models\Errors\InvalidArgumentException;

/** 
 * Must be extended by concrete criteria
 */
abstract class SearchCriteria implements SearchCriteriaInterface
{
    protected array $orderBy = [];

    public function __construct(
        protected readonly string $entityIdFieldName,
        protected readonly string $tableName,
        protected string $limit = 'all',
        protected string $offset = '0'
    ) {}

    public function getEntityIdFieldName(): string
    {
        return $this->entityIdFieldName;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getAllOrderBy(): array
    {
        return $this->orderBy;
    }

    public function setOrderBy(OrderByInterface $orderBy): self
    {
        $this->orderBy[] = $orderBy;
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
