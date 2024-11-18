<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleList;

final class Pagination
{
    public const LIMIT_FIELD = 'limit';
    public const OFFSET_FIELD = 'offset';

    public function __construct(
        protected string $limit,
        protected string $offset,
    ) {}

    /** @param array<string,string> $hash */
    public static function fromRequest(array $hash): self
    {
        return new self(
            $hash[self::LIMIT_FIELD] ?? '',
            $hash[self::OFFSET_FIELD] ?? ''
        );
    }

    public function limit(): string
    {
        return $this->limit;
    }

    public function offset(): string
    {
        return $this->offset;
    }

}
