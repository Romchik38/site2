<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleService\Commands;

use function is_string;

final class Create
{
    public const ID_FIELD     = 'id';
    public const AUTHOR_FIELD = 'author_row';

    private function __construct(
        public readonly string $id,
        public readonly string $authorId
    ) {
    }

    /** @param array<string,mixed> $hash */
    public static function formHash(array $hash): self
    {
        $id    = '';
        $rawId = $hash[self::ID_FIELD] ?? '';
        if (is_string($rawId)) {
            $id = $rawId;
        }

        $authorId    = '';
        $rawAuthorId = $hash[self::AUTHOR_FIELD] ?? '';
        if (is_string($rawAuthorId)) {
            $authorId = $rawAuthorId;
        }

        return new self($id, $authorId);
    }
}
