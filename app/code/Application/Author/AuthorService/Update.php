<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AuthorService;

final class Update
{
    public const ID_FIELD = 'id';
    public const NAME_FIELD = 'name';
    public const CHANGE_ACTIVITY_FIELD = 'change_activity';

    private function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $changeActivity
    ) {   
    }

    public static function formHash(array $hash): self
    {
        return new self(
            $hash[self::ID_FIELD] ?? '',
            $hash[self::ID_FIELD] ?? '',
            $hash[self::ID_FIELD] ?? '',
        );
    }
}
