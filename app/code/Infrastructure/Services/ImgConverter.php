<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services;

use Romchik38\Server\Services\Streams\StreamToString;
use Romchik38\Site2\Application\ImgConverter\ImgConverterInterface;
use Romchik38\Site2\Application\ImgConverter\View\Height;
use Romchik38\Site2\Application\ImgConverter\View\ImgResult;
use Romchik38\Site2\Application\ImgConverter\View\Type;
use Romchik38\Site2\Application\ImgConverter\View\Width;
use Romchik38\Site2\Infrastructure\Services\ImgConverter\Image;

class ImgConverter implements ImgConverterInterface
{
    /** must be in sinc with $this->createFrom() */
    protected array $capabilities = [
        'webp' => 'WebP Support'
    ];

    public function __construct()
    {
        if (extension_loaded('gd') === false) {
            throw new \RuntimeException('GD extension not loaded');
        }
    }

    public function create(
        string $filePath,
        Width $copyWidth,
        Height $copyHeight,
        Type $copyType
    ): ImgResult {
        $image = new Image(
            $filePath,
            $copyWidth,
            $copyHeight,
            $copyType
        );

        if ($this->checkGDcapabilities($image->originalType) === false) {
            throw new \RuntimeException(sprintf(
                'GD library do not support type %',
                $image->originalType
            ));
        };

        if ($this->checkGDcapabilities($image->copyType) === false) {
            throw new \RuntimeException(sprintf(
                'GD library do not support type %',
                $image->copyType
            ));
        };

        $copy = imagecreatetruecolor($image->copyWidth, $image->copyHeight);
        $original = $this->createFrom($image->filePath, $image->originalType);

        imagecopyresampled(
            $copy,
            $original,
            0,
            0,
            0,
            0,
            $image->copyWidth,
            $image->copyHeight,
            $image->originalWidth,
            $image->originalHeight
        );

        $imgAsString = $this->createTo($copy, $image->copyType);

        return new ImgResult($image->copyMimeType, $imgAsString);
    }

    protected function createFrom(string $path, string $type): \GdImage
    {
        $result = false;
        if ($type === 'webp') {
            $result = imagecreatefromwebp($path);
        } else {
            throw new \RuntimeException(
                sprintf(
                    'Image creation for type %s not supported',
                    $type
                )
            );
        }

        if ($result === false) {
            throw new \RuntimeException(
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
            $stream = new StreamToString();

            //imagewebp($image, __DIR__ . '/../../../var/1.webp');
            $result = $stream('imagewebp', 1, $image);
        } else {
            throw new \RuntimeException(
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
            throw new \RuntimeException(sprintf('Type %s not supported by converter'));
        }
        $capability = $info[$key] ?? null;
        if (is_null($capability)) {
            throw new \RuntimeException(
                sprintf(
                    'ImgConverter internal error. Capability %s is expected, but not found',
                    $key
                )
            );
        }
        return $capability;
    }
}
