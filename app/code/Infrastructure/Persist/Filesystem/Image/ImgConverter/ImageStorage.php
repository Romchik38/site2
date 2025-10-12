<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Filesystem\Image\ImgConverter;

use InvalidArgumentException;
use Romchik38\Site2\Application\Image\ImgConverter\CouldNotCreateImageException;
use Romchik38\Site2\Application\Image\ImgConverter\ImageStorageInterface;
use Romchik38\Site2\Application\Image\ImgConverter\View\Height;
use Romchik38\Site2\Application\Image\ImgConverter\View\ImgResult;
use Romchik38\Site2\Application\Image\ImgConverter\View\Width;
use Romchik38\Site2\Domain\Image\VO\Path;
use Romchik38\Site2\Domain\Image\VO\Type;
use Romchik38\Site2\Infrastructure\Persist\Filesystem\Image\AbstractImageStorageUseGd;
use Romchik38\Site2\Infrastructure\Persist\Filesystem\Image\CopyImage;
use RuntimeException;

use function filesize;
use function imagecopyresampled;
use function imagecreatetruecolor;
use function round;
use function sprintf;

use const PHP_ROUND_HALF_DOWN;

class ImageStorage extends AbstractImageStorageUseGd implements ImageStorageInterface
{
    public function __construct(
        protected readonly string $imgPathPrefix
    ) {
    }

    public function makeCopy(
        Path $path,
        Width $copyWidth,
        Height $copyHeight,
        Type $copyType,
        int $quality = 90
    ): ImgResult {
        // 1. Create an image with all data
        $filePath = $this->createFullPath($path);
        try {
            $demensions = $this->getDemensionsFromFile($filePath);
        } catch (RuntimeException $e) {
            throw new CouldNotCreateImageException($e->getMessage());
        }

        $fileSize = filesize($filePath);
        if ($fileSize === false) {
            throw new CouldNotCreateImageException(sprintf(
                'Could not determine size of the file %s',
                $filePath
            ));
        }

        /** CopyImage is responsable to do all checks */
        try {
            $image = new CopyImage(
                $demensions,
                $fileSize,
                $copyWidth,
                $copyHeight,
                $copyType
            );
        } catch (InvalidArgumentException $e) {
            throw new CouldNotCreateImageException($e->getMessage());
        }

        // 2. Check capabilities
        try {
            $this->checkGDcapabilities($image->type);
            $this->checkGDcapabilities($image->copyType);
        } catch (RuntimeException $e) {
            throw new CouldNotCreateImageException($e->getMessage());
        }

        // 3 calculate $temporaryWidth / $temporaryHeight
        if ($image->copyWidth > $image->copyHeight) {
            $minCopy = $image->copyWidth;
        } else {
            $minCopy = $image->copyHeight;
        }
        if ($image->width > $image->height) {
            $scaleRatio = $image->height / $minCopy;
        } else {
            $scaleRatio = $image->width / $minCopy;
        }
        $temporaryWidth  = (int) ($image->width / $scaleRatio);
        $temporaryHeight = (int) ($image->height / $scaleRatio);
        if ($temporaryWidth <= 0 || $temporaryHeight <= 0) {
            throw new CouldNotCreateImageException(
                sprintf('Image width/height must be greater than 0 in %s', $filePath)
            );
        }

        // 4. Load original image
        try {
            $original = $this->createImageFromFile($filePath, $image->type);
        } catch (RuntimeException $e) {
            throw new CouldNotCreateImageException($e->getMessage());
        }

        // 5. Create temporary copy
        $temporary = imagecreatetruecolor($temporaryWidth, $temporaryHeight);
        if ($temporary === false) {
            throw new CouldNotCreateImageException(
                sprintf('Cannot create temporary image for %s', $filePath)
            );
        }

        // 6. Fill temporary
        $resultFillTemporary = imagecopyresampled(
            $temporary,
            $original,
            0,
            0,
            0,
            0,
            $temporaryWidth,
            $temporaryHeight,
            $image->width,
            $image->height
        );
        if ($resultFillTemporary === false) {
            throw new CouldNotCreateImageException(
                sprintf('Cannot fill temporary image for %s', $filePath)
            );
        }

        $copy = imagecreatetruecolor($image->copyWidth, $image->copyHeight);
        if ($copy === false) {
            throw new CouldNotCreateImageException(
                sprintf('Cannot create copy image for %s', $filePath)
            );
        }

        // 8. Define indent
        $srcX = (int) round(($temporaryWidth - $image->copyWidth) / 2, 0, PHP_ROUND_HALF_DOWN);
        $srcY = (int) round(($temporaryHeight - $image->copyHeight) / 2, 0, PHP_ROUND_HALF_DOWN);

        imagecopyresampled(
            $copy,
            $temporary,
            0,
            0,
            $srcX,
            $srcY,
            $image->copyWidth,
            $image->copyHeight,
            $image->copyWidth,
            $image->copyHeight,
        );

        try {
            $imgAsString = $this->saveImageToString($copy, $image->copyType, $quality);
        } catch (RuntimeException $e) {
            throw new CouldNotCreateImageException($e->getMessage());
        }

        return new ImgResult($image->copyType, $imgAsString);
    }

    private function createFullPath(Path $path): string
    {
        return sprintf(
            '%s/%s',
            $this->imgPathPrefix,
            $path()
        );
    }
}
