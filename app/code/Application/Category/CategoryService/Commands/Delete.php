<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\CategoryService\Commands;

final class Delete
{
    public const ID_FIELD = 'id';

    private function __construct(
        public readonly string $id
    ) {
    }

    /** @param array<string,string> $hash */
    public static function formHash(array $hash): self
    {
        return new self(
            $hash[self::ID_FIELD] ?? ''
        );
    }
}
