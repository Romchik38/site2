<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\SearchCriteria;

use Romchik38\Server\Api\Models\SearchCriteria\OrderByInterface;
use Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaInterface;
use Romchik38\Server\Models\Errors\InvalidArgumentException;

/** 
 * Must be extended by concrete criteria.
 * Params $limit, offset and orderBy can be provided via __construct or setted latter
 */
abstract class SearchCriteria implements SearchCriteriaInterface
{
    protected array $orderBy;
    protected string $limit;
    protected string $offset;

    public function __construct(
        protected readonly string $entityIdFieldName,
        protected readonly string $tableName,
        string $limit = 'all',
        string $offset = '0',
        array $orderBy = []
    ) {
        $this->setLimit($limit);
        $this->setOffset($offset);
        foreach ($orderBy as $item) {
            $this->setOrderBy($item);
        }
    }

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
