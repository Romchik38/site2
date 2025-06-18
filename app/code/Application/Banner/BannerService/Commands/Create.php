<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Banner\BannerService\Commands;

use function is_string;

final class Create
{
    public const NAME_FIELD  = 'name';
    public const IMAGE_FIELD = 'image_row';

    private function __construct(
        public readonly string $name,
        public readonly string $imageId
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

        $imageId    = '';
        $rawImageId = $hash[self::IMAGE_FIELD] ?? '';
        if (is_string($rawImageId)) {
            $imageId = $rawImageId;
        }

        return new self($name, $imageId);
    }
}
