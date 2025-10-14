<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Filesystem\Image;

use InvalidArgumentException;
use Romchik38\Site2\Application\Image\ImgConverter\View\Height;
use Romchik38\Site2\Application\Image\ImgConverter\View\Width;
use Romchik38\Site2\Domain\Image\VO\Type;

use function sprintf;

final class CopyImage extends Image
{
    /** @var int<1,max> $copyWidth */
    public readonly int $copyWidth;
    /** @var int<1,max> $copyHeight */
    public readonly int $copyHeight;
    public readonly string $copyType;
    public readonly string $copyMimeType;

    /**
     * @param array<int|string,mixed> $dimensions
     * @throws InvalidArgumentException
     * */
    public function __construct(
        array $dimensions,
        int $size,
        Width $copyWidth,
        Height $copyHeight,
        Type $copyType,
    ) {
        parent::__construct($dimensions, $size);

        if ($copyWidth() <= 0 || $copyHeight() <= 0) {
            throw new InvalidArgumentException('Image copy width/height must be greater than 0');
        } else {
            $this->copyWidth  = $copyWidth();
            $this->copyHeight = $copyHeight();
        }

        if (
            $this->width < $this->copyWidth
            || $this->height < $this->copyHeight
        ) {
            throw new InvalidArgumentException(
                sprintf(
                    'Image too small to resize. Original width %s, height %s. Copy width %s, height %s',
                    $this->width,
                    $this->height,
                    $this->copyWidth,
                    $this->copyHeight
                )
            );
        }

        $this->copyType     = $copyType();
        $this->copyMimeType = 'image/' . $this->copyType;
    }
}
