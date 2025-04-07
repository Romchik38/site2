<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image;

use GdImage;
use InvalidArgumentException;
use Romchik38\Server\Services\Streams\TempStream;
use Romchik38\Site2\Application\Image\ImgConverter\CouldNotCreateImageException;
use Romchik38\Site2\Application\Image\ImgConverter\ImgConverterInterface;
use Romchik38\Site2\Application\Image\ImgConverter\View\Height;
use Romchik38\Site2\Application\Image\ImgConverter\View\ImgResult;
use Romchik38\Site2\Application\Image\ImgConverter\View\Width;
use Romchik38\Site2\Domain\Image\VO\Type;
use Romchik38\Site2\Infrastructure\Services\Image\CopyImage;
use RuntimeException;

use function imagecopyresampled;
use function imagecreatefromwebp;
use function imagecreatetruecolor;
use function round;
use function sprintf;

use const PHP_ROUND_HALF_DOWN;

class ImgConverter extends AbstractImageStorageUseGd implements ImgConverterInterface
{
    use DimensionsTraits;

    public function makeCopy(
        string $filePath,
        Width $copyWidth,
        Height $copyHeight,
        Type $copyType,
        int $quality = 90
    ): ImgResult {
        // 1. Create an image with all data
        try {
            $demensions = $this->fromFilePath($filePath);
        } catch (RuntimeException $e) {
            throw new CouldNotCreateImageException($e->getMessage());
        }

        try {
            $image = new CopyImage($demensions, $copyWidth, $copyHeight, $copyType);
        } catch (InvalidArgumentException $e) {
            throw new CouldNotCreateImageException($e->getMessage());
        }


        if ($image->copyWidth <= 0 || $image->copyHeight <= 0) {
            throw new CouldNotCreateImageException(
                sprintf('Image width/height must be greater than 0 in %s', $filePath)
            );
        }

        // 2. Check capabilities
        try {
            $this->checkGDcapabilities($image->originalType);
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
        if ($image->originalWidth > $image->originalHeight) {
            $scaleRatio = $image->originalHeight / $minCopy;
        } else {
            $scaleRatio = $image->originalWidth / $minCopy;
        }
        $temporaryWidth  = (int) ($image->originalWidth / $scaleRatio);
        $temporaryHeight = (int) ($image->originalHeight / $scaleRatio);
        if ($temporaryWidth <= 0 || $temporaryHeight <= 0) {
            throw new CouldNotCreateImageException(
                sprintf('Image width/height must be greater than 0 in %s', $filePath)
            );
        }

        // 4. Load original image
        $original = $this->createFrom($filePath, $image->originalType);
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
            $image->originalWidth,
            $image->originalHeight
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

        $imgAsString = $this->createTo($copy, $image->copyType, $quality);

        return new ImgResult($image->copyType, $imgAsString);
    }

    protected function createFrom(string $path, string $type): GdImage
    {
        $result = false;
        if ($type === 'webp') {
            $result = imagecreatefromwebp($path);
        } else {
            throw new CouldNotCreateImageException(
                sprintf(
                    'Image creation for type %s not supported',
                    $type
                )
            );
        }

        if ($result === false) {
            throw new CouldNotCreateImageException(
                sprintf(
                    'failed attempt to create image %s',
                    $path
                )
            );
        } else {
            return $result;
        }
    }

    protected function createTo(GdImage $image, string $type, int $quality): string
    {
        $result = '';
        if ($type === 'webp') {
            $stream = new TempStream();
            $stream->writeFromCallable('imagewebp', 1, $image, null, $quality);
            $result = $stream();
        } else {
            throw new CouldNotCreateImageException(
                sprintf(
                    'Image creation for type %s not supported',
                    $type
                )
            );
        }

        return $result;
    }
}
