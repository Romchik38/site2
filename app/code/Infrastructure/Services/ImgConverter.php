<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services;

use Romchik38\Site2\Application\ImgConverter\ImgConverterInterface;
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

    public function create(Image $img): string
    {

        if ($this->checkGDcapabilities($img->originalType) === false) {
            throw new \RuntimeException(sprintf(
                'GD library do not support type %',
                $img->originalType
            ));
        };

        if ($this->checkGDcapabilities($img->copyType) === false) {
            throw new \RuntimeException(sprintf(
                'GD library do not support type %',
                $img->copyType
            ));
        };

        $copy = imagecreatetruecolor($img->copyWidth, $img->copyHeight);
        $original = $this->createFrom($img->filePath, $img->originalType);

        imagecopyresampled(
            $copy,
            $original,
            0,
            0,
            0,
            0,
            $img->copyWidth,
            $img->copyHeight,
            $img->originalWidth,
            $img->originalHeight
        );



        return '';
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

    protected function createTo(\GdImage $image, string $type): void
    {
        $result = false;
        if ($type === 'webp') {
            $result = imagewebp($image);
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
