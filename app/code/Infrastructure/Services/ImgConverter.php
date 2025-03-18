<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services;

use Romchik38\Server\Services\Streams\TempStream;
use Romchik38\Site2\Application\Image\ImgConverter\CouldNotCreateImageException;
use Romchik38\Site2\Application\Image\ImgConverter\ImgConverterInterface;
use Romchik38\Site2\Application\Image\ImgConverter\View\Height;
use Romchik38\Site2\Application\Image\ImgConverter\View\ImgResult;
use Romchik38\Site2\Application\Image\ImgConverter\View\Type;
use Romchik38\Site2\Application\Image\ImgConverter\View\Width;
use Romchik38\Site2\Infrastructure\Services\ImgConverter\Image;

class ImgConverter implements ImgConverterInterface
{
    /** 
     * Must be in sinc with $this->createFrom() & createTo()
     * @var array<string,string> $capabilities
     * 
    */
    protected array $capabilities = [
        'webp' => 'WebP Support'
    ];

    public function __construct(
        protected readonly int $quality = 90
    ) {
        if (extension_loaded('gd') === false) {
            throw new CouldNotCreateImageException('GD extension not loaded');
        }
    }

    public function create(
        string $filePath,
        Width $copyWidth,
        Height $copyHeight,
        Type $copyType
    ): ImgResult {

        // 1. Create an image with all data
        $image = new Image(
            $filePath,
            $copyWidth,
            $copyHeight,
            $copyType
        );

        // 2. Check capabilities
        if ($this->checkGDcapabilities($image->originalType) === false) {
            throw new CouldNotCreateImageException(sprintf(
                'GD library do not support type %s',
                $image->originalType
            ));
        };

        if ($this->checkGDcapabilities($image->copyType) === false) {
            throw new CouldNotCreateImageException(sprintf(
                'GD library do not support type %s',
                $image->copyType
            ));
        };

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
        $temporaryWidth = (int)($image->originalWidth / $scaleRatio);
        $temporaryHeight = (int)($image->originalHeight / $scaleRatio);

        // 4. Load original image
        $original = $this->createFrom($image->filePath, $image->originalType);
        // 5. Create temporary copy
        $temporary = imagecreatetruecolor($temporaryWidth, $temporaryHeight);
        if ($temporary === false) {
            throw new CouldNotCreateImageException(
                sprintf('Cannot create temporary image for %s', $image->filePath)
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
                sprintf('Cannot fill temporary image for %s', $image->filePath)
            );
        }

        $copy = imagecreatetruecolor($image->copyWidth, $image->copyHeight);
        if ($copy === false) {
            throw new CouldNotCreateImageException(
                sprintf('Cannot create copy image for %s', $image->filePath)
            );
        }

        // 8. Define indent
        $srcX = (int)round(($temporaryWidth - $image->copyWidth) / 2, 0, PHP_ROUND_HALF_DOWN);
        $srcY = (int)round(($temporaryHeight - $image->copyHeight) / 2, 0, PHP_ROUND_HALF_DOWN);

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

        $imgAsString = $this->createTo($copy, $image->copyType);

        return new ImgResult($image->copyType, $imgAsString);
    }

    protected function createFrom(string $path, string $type): \GdImage
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

    protected function createTo(\GdImage $image, string $type): string
    {
        $result = '';
        if ($type === 'webp') {
            $stream = new TempStream();
            $stream->writeFromCallable('imagewebp', 1, $image, null, $this->quality);
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

    protected function checkGDcapabilities(string $type): bool
    {
        $info = gd_info();
        $key = $this->capabilities[$type] ?? null;
        if (is_null($key)) {
            throw new CouldNotCreateImageException(sprintf('Type %s not supported by converter', $type));
        }
        $capability = $info[$key] ?? null;
        if (is_null($capability)) {
            throw new CouldNotCreateImageException(
                sprintf(
                    'ImgConverter internal error. Capability %s is expected, but not found',
                    $key
                )
            );
        }
        return $capability;
    }
}
