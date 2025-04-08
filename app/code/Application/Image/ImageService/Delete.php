<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImageService;

use function gettype;

final class Delete
{
    public const ID_FIELD = 'id';

    private function __construct(
        public readonly string $id
    ) {
    }

    /** @param array<string,mixed> $hash */
    public static function formHash(array $hash): self
    {
        $id = $hash[self::ID_FIELD] ?? '';
        if (gettype($id) !== 'string') {
            $id = '';
        }
        return new self($id);
    }
}
