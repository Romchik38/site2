<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Img;

final class ImgData
{
    public const ID_FIELD = 'id';
    public const TYPE_FIELD = 'type';
    public const WIDTH_FIELD = 'width';
    public const HEIGHT_FIELD = 'height';

    public function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly string $width,
        public readonly string $height
    ) {}

    public static function fromRequest(array $hash): self
    {
        return new ImgData(
            $hash[self::ID_FIELD] ?? '',
            $hash[self::TYPE_FIELD] ?? '',
            $hash[self::WIDTH_FIELD] ?? '',
            $hash[self::HEIGHT_FIELD] ?? '',
        );
    }
}
