<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AudioService;

use function is_string;

final class Update
{
    public const ID_FIELD                  = 'id';
    public const NAME_FIELD                = 'name';
    public const CHANGE_ACTIVITY_FIELD     = 'change_activity';
    public const CHANGE_ACTIVITY_YES_FIELD = 'yes';
    public const CHANGE_ACTIVITY_NO_FIELD  = 'no';

    private function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $changeActivity,
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

        $name    = '';
        $rawName = $hash[self::NAME_FIELD] ?? '';
        if (is_string($rawName)) {
            $name = $rawName;
        }

        $changeActivity    = '';
        $rawChangeActivity = $hash[self::CHANGE_ACTIVITY_FIELD] ?? '';
        if (is_string($rawChangeActivity)) {
            $changeActivity = $rawChangeActivity;
        }

        return new self($id, $name, $changeActivity);
    }
}
