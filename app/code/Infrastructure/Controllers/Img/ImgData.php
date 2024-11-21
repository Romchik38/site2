<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Img;

final class ImgData
{
    public const ID_FIELD = 'id';
    public const TYPE_FIELD = 'type';
    public const ASPECT_RATIO_FIELD = 'aspect_ratio';
    public const SIZE_FIELD = 'size';

    public function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly string $aspectRatio,
        public readonly string $size
    ) {}

    public static function fromRequest(array $hash): self
    {
        return new ImgData(
            $hash[self::ID_FIELD] ?? '',
            $hash[self::TYPE_FIELD] ?? '',
            $hash[self::ASPECT_RATIO_FIELD] ?? '',
            $hash[self::SIZE_FIELD] ?? '',
        );
    }
}
