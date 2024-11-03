<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\Services\CO;

use ReflectionFunctionAbstract;

final class Pagination
{
    public const LIMIT_FIELD = 'limit';
    public const OFFSET_FIELD = 'offset';

    public const DEFAULT_LIMIT = '15';
    public const DEFAULT_OFFSET = '0';

    protected string $limit;
    protected string $offset;

    /** @var array<int,string> $errors*/
    protected $errors = [];

    public function __construct(
        array $hash = []
    ) {
        $limit = $hash[$this::LIMIT_FIELD] ?? null;
        if ($limit === null) {
            $this->limit = $this::DEFAULT_LIMIT;
            $this->errors[] = sprintf(
                'Pagination limit was not provided. Limit set to default %s',
                $this::DEFAULT_LIMIT
            );
        }

        $offset = $hash[$this::OFFSET_FIELD] ?? null;
        if ($offset === null) {
            $this->offset = $this::DEFAULT_OFFSET;
            $this->errors[] = sprintf(
                'Pagination offset was not provided. Offset set to default %s',
                $this::DEFAULT_OFFSET
            );
        }
    }

    public function limit(): string
    {
        return $this->limit;
    }

    public function offset(): string
    {
        return $this->offset;
    }

    /** @return array<int,string> */
    public function errors(): array
    {
        return $this->errors();
    }
}
