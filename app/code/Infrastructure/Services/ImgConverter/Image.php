<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\ImgConverter;

use Romchik38\Site2\Application\Image\ImgConverter\View\Height;
use Romchik38\Site2\Domain\Image\VO\Type;
use Romchik38\Site2\Application\Image\ImgConverter\View\Width;
use RuntimeException;

use function explode;
use function file_exists;
use function getimagesize;
use function in_array;
use function is_readable;
use function sprintf;

final class Image
{
    /** 
     * Types to convert. 
     * The loaded from storage image must be in array to be converted 
     * */
    protected const ALLOWED_MIME = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    public readonly int $originalWidth;
    public readonly int $originalHeight;
    public readonly string $originalType;
    public readonly int $copyWidth;
    public readonly int $copyHeight;
    public readonly string $copyType;
    public readonly string $copyMimeType;

    public function __construct(
        public readonly string $filePath,
        Width $copyWidth,
        Height $copyHeight,
        Type $copyType,
    ) {
        $this->copyWidth  = $copyWidth();
        $this->copyHeight = $copyHeight();

        if (! file_exists($filePath) || (! is_readable($filePath))) {
            throw new RuntimeException(sprintf(
                'Image file %s not exist',
                $filePath
            ));
        }

        $dimensions = getimagesize($filePath);
        if ($dimensions === false) {
            throw new RuntimeException(sprintf(
                'File %s is not an image',
                $filePath
            ));
        }

        $originalWidth = $dimensions[0];
        if ($originalWidth === 0) {
            throw new RuntimeException(sprintf(
                'Cannot determine image width size of %s',
                $filePath
            ));
        }
        $this->originalWidth  = $originalWidth;
        $this->originalHeight = $dimensions[1];

        if (
            $this->originalWidth < $this->copyWidth
            || $this->originalHeight < $this->copyHeight
        ) {
            throw new RuntimeException(
                sprintf(
                    'Image too small to resize. Original width %s, height %s. Copy width %s, height %s',
                    $this->originalWidth,
                    $this->originalHeight,
                    $this->copyWidth,
                    $this->copyHeight
                )
            );
        }

        $mime = $dimensions['mime'];
        if (! in_array($mime, self::ALLOWED_MIME)) {
            throw new RuntimeException(sprintf(
                'Original image type %s not allowed',
                $mime
            ));
        }
        $this->originalType = (explode('/', $mime))[1];
        if (! in_array('image/' . $copyType(), self::ALLOWED_MIME)) {
            throw new RuntimeException(sprintf(
                'Original image type %s not allowed',
                $mime
            ));
        }
        $this->copyType     = $copyType();
        $this->copyMimeType = 'image/' . $this->copyType;
    }
}
