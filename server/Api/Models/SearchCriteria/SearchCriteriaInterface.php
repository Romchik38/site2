<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\SearchCriteria;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

/**
 * @api
 */
interface SearchCriteriaInterface
{
    /**
     * REPOSITORY SECTION
     */

    /** a column name to select */
    public function getEntityIdFieldName(): string;

    /** from table name */
    public function getTableName(): string;

    /** @return OrderByInterface[] */
    public function getAllOrderBy(): array;

    public function limit(): LimitInterface;

    public function offset(): OffsetInterface;

    /**
    * DOMAIN SECTION
    */

    /** 
     * @param OrderByInterface $orderBy A sorting rule
     */
    public function setOrderBy(OrderByInterface $orderBy): self;

    public function setLimit(LimitInterface $limit): self;

    public function setOffset(OffsetInterface $offset): self;
}
