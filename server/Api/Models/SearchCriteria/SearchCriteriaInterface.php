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

    /**
    * DOMAIN SECTION
    */

    /** 
     * @param OrderByInterface $orderBy A sorting rule
     */
    public function setOrderBy(OrderByInterface $orderBy): self;

    /**
     * @throws InvalidArgumentException on limit < 0 
     * */
    public function setLimit(LimitInterface $limit): self;

    /** @throws InvalidArgumentException on offset < 0 */
    public function setOffset(string $offset): self;
}
