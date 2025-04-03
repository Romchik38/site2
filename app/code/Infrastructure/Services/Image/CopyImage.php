<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image;

use Romchik38\Site2\Application\Image\ImgConverter\View\Height;
use Romchik38\Site2\Application\Image\ImgConverter\View\Width;
use Romchik38\Site2\Domain\Image\VO\Type;
use RuntimeException;

use function sprintf;

final class CopyImage extends Image
{
    /**
     * Types to convert.
     * The loaded from storage image must be in array to be converted
     * */
    //protected const ALLOWED_MIME = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    public readonly int $copyWidth;
    public readonly int $copyHeight;
    public readonly string $copyType;
    public readonly string $copyMimeType;

    public function __construct(
        string $filePath,
        Width $copyWidth,
        Height $copyHeight,
        Type $copyType,
    ) {
        parent::__construct($filePath);
        
        $this->copyWidth  = $copyWidth();
        $this->copyHeight = $copyHeight();

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

        $this->copyType     = $copyType();
        $this->copyMimeType = 'image/' . $this->copyType;
    }
}
