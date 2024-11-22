<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\ImgConverter;

use Romchik38\Site2\Application\ImgConverter\View\Height;
use Romchik38\Site2\Application\ImgConverter\View\Type;
use Romchik38\Site2\Application\ImgConverter\View\Width;

final class Image
{
    protected const ALLOWED_MIME = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    public readonly int $originalWidth;
    public readonly int $originalHeight;
    public readonly string $originalType;
    public readonly int $copyWidth;
    public readonly int $copyHeight;
    public readonly string $copyType;

    /** @todo ? is $filePath needed as property */
    public function __construct(
        protected readonly string $filePath,
        Width $copyWidth,
        Height $copyHeight,
        Type $copyType,
    ) {
        $this->copyWidth = $copyWidth();
        $this->copyHeight = $copyHeight();

        if (!file_exists($filePath) || (!is_readable($filePath))) {
            throw new \RuntimeException(sprintf(
                'Image file %s not exist',
                $filePath
            ));
        }

        $dimensions = getimagesize($filePath);
        if ($dimensions === false) {
            throw new \RuntimeException(sprintf(
                'File %s is not an image',
                $filePath
            ));
        }

        $originalWidth = $dimensions[0];
        if ($originalWidth === 0) {
            throw new \RuntimeException(sprintf(
                'Cannot determine image width size of %s',
                $filePath
            ));
        }
        $this->originalWidth = $originalWidth;
        $this->originalHeight = $dimensions[1];

        if (
            $this->originalWidth < $this->copyWidth
            || $this->originalHeight < $this->copyHeight
        ) {
            throw new \RuntimeException('Target img side is bigger than original');
        }

        $mime = $dimensions['mime'];
        if (!in_array($mime, self::ALLOWED_MIME)) {
            throw new \RuntimeException(sprintf(
                'Original image type %s not allowed',
                $mime
            ));
        }
        $this->originalType = (explode('/', $mime))[1];
        if (!in_array('image/' . $copyType(), self::ALLOWED_MIME)) {
            throw new \RuntimeException(sprintf(
                'Original image type %s not allowed',
                $mime
            ));
        }
        $this->copyType = $copyType();
    }
}
