<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\Sql\SearchCriteria;

use Romchik38\Server\Api\Models\SearchCriteria\FilterInterface;
use Romchik38\Server\Api\Models\SearchCriteria\LimitInterface;
use Romchik38\Server\Api\Models\SearchCriteria\OffsetInterface;
use Romchik38\Server\Api\Models\SearchCriteria\OrderByInterface;
use Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaInterface;

/** 
 * Must be extended by concrete criteria.
 * Params $limit, offset and orderBy can be provided via __construct or setted latter
 */
abstract class SearchCriteria implements SearchCriteriaInterface
{
    protected FilterInterface|null $filter = null;

    /** @param array<int,OrderByInterface> $orderBy */
    public function __construct(
        protected readonly string $entityIdFieldName,
        protected readonly string $tableName,
        protected LimitInterface $limit,
        protected OffsetInterface $offset,
        protected array $orderBy = []
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

    public function limit(): LimitInterface {
        return $this->limit;
    }

    public function offset(): OffsetInterface {
        return $this->offset;
    }
    
    public function setOrderBy(OrderByInterface $orderBy): self
    {
        $this->orderBy[] = $orderBy;
        return $this;
    }

    public function setLimit(LimitInterface $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function setOffset(OffsetInterface $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    public function addFilter(FilterInterface $filter): self
    {
        $this->filter = $filter;
        return $this;
    }

    public function getFilter(): FilterInterface|null {
        return $this->filter;
    }
}
