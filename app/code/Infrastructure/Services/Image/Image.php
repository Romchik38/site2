<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image;

use Romchik38\Site2\Domain\Image\VO\Type;
use RuntimeException;

use function explode;
use function file_exists;
use function getimagesize;
use function in_array;
use function is_readable;
use function sprintf;

class Image
{
    /**
     * Types to convert.
     * The loaded from storage image must be in array to be converted
     * */
    //protected const ALLOWED_MIME = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    public readonly int $originalWidth;
    public readonly int $originalHeight;
    public readonly string $originalType;

    /** @throws RuntimeException */
    public function __construct(
        public readonly string $filePath,
    ) {
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

        $mime               = $dimensions['mime'];
        $this->originalType = (explode('/', $mime))[1];

        if (! in_array($this->originalType, Type::ALLOWED_TYPES)) {
            throw new RuntimeException(sprintf(
                'Original image type %s not allowed',
                $this->originalType
            ));
        }
    }
}
