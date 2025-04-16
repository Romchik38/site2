<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AudioService;

use function is_string;

final class Create
{
    public const NAME_FIELD = 'name';

    private function __construct(
        public readonly string $name
    ) {
    }

    /** @param array<string,mixed> $hash */
    public static function formHash(array $hash): self
    {
        $name    = '';
        $rawName = $hash[self::NAME_FIELD] ?? '';
        if (is_string($rawName)) {
            $name = $rawName;
        }

        return new self($name);
    }
}
