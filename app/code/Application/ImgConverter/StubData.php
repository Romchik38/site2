<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImgConverter;

final class StubData
{
    public const TYPE_FIELD = 'type';
    public const WIDTH_FIELD = 'width';
    public const HEIGHT_FIELD = 'height';

    public function __construct(
        public readonly string $filePath,
        public readonly string $type,
        public readonly string $width,
        public readonly string $height
    ) {}

    public static function fromRequest(array $hash, string $filePath): self
    {
        return new self(
            $filePath,
            $hash[self::TYPE_FIELD] ?? '',
            $hash[self::WIDTH_FIELD] ?? '',
            $hash[self::HEIGHT_FIELD] ?? '',
        );
    }
}
