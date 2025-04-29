<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html\Classes;

use InvalidArgumentException;
use Romchik38\Site2\Infrastructure\Http\Views\Html\PaginationInterface;

use function array_values;

final class Pagination2 implements PaginationInterface
{
    /** @var array<string,Query> */
    private array $hash = [];

    /** @param array<int,mixed|Query> $queries */
    public function __construct(
        public readonly int $limit,
        public readonly string $limitFieldName,
        public readonly int $page,
        public readonly string $pageFieldName,
        public readonly int $totalCount,
        array $queries
    ) {
        foreach ($queries as $query) {
            if (! $query instanceof Query) {
                throw new InvalidArgumentException('Parm query is invalid');
            }
            $this->hash[$query->key] = $query;
        }
    }

    /** @return array<int,Query> */
    public function getQueries(): array
    {
        return array_values($this->hash);
    }

    /**
     * @todo remove after implementation
     *
     *          all methods
     *             \  /
     *              \/
     * */
    public function limit(): string
    {
        return ($this->hash[self::LIMIT_FIELD])->value;
    }

    public function page(): string
    {
        return ($this->hash[self::PAGE_FIELD])->value;
    }

    public function orderByField(): string
    {
        return ($this->hash[self::ORDER_BY_FIELD])->value;
    }

    public function orderByDirection(): string
    {
        return ($this->hash[self::ORDER_BY_DIRECTION_FIELD])->value;
    }

    public function totalCount(): int
    {
        return $this->totalCount;
    }
}
