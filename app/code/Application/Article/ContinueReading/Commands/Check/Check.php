<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ContinueReading\Commands\Check;

use function is_string;

final class Check
{
    public const ID_FIELD = 'id';

    public function __construct(
        public readonly string $id
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

        return new self($id);
    }
}
