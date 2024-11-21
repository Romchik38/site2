<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Img;

final class ImgData
{
    public const NAME_FIELD = 'name';
    public const TYPE_FIELD = 'type';
    public const ASPECT_RATIO_FIELD = 'aspect_ratio';
    public const SIZE_FIELD = 'size';

    public function __construct(
        protected readonly string $name,
        protected readonly string $type,
        protected readonly string $aspectRation,
        protected readonly string $size
    ) {}

    public static function fromRequest(array $hash): self
    {
        return new ImgData(
            $hash[self::NAME_FIELD] ?? '',
            $hash[self::TYPE_FIELD] ?? '',
            $hash[self::ASPECT_RATIO_FIELD] ?? '',
            $hash[self::SIZE_FIELD] ?? '',
        );
    }
}
