<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image;

use GdImage;
use Romchik38\Server\Services\Streams\TempStream;
use RuntimeException;

abstract class AbstractImageStorageUseGd
{
    /**
     * @var array<string,string> $capabilities
     */
    protected array $capabilities = [
        'webp' => 'WebP Support',
    ];

    /** @throws RuntimeException */
    public function __construct() 
    {
        if (extension_loaded('gd') === false) {
            throw new RuntimeException('GD extension not loaded');
        }
    }

    /** @throws RuntimeException */
    protected function checkGDcapabilities(string $type): void
    {
        $info = gd_info();
        $key  = $this->capabilities[$type] ?? null;
        if ($key === null) {
            throw new RuntimeException(sprintf('Type %s not supported by converter', $type));
        }
        $capability = $info[$key] ?? null;
        if ($capability === null) {
            throw new RuntimeException(
                sprintf(
                    'ImgConverter internal error. Capability %s is expected, but not found',
                    $key
                )
            );
        }
        if ($capability === false) {
            throw new RuntimeException(
                sprintf('GD library do not support type %s', $type)
            );
        }
    }

    /** 
     * @throws RuntimeException
     */
    protected function createImageFromFile(string $fullPath, string $type): GdImage
    {
        $result = false;
        if ($type === 'webp') {
            $result = imagecreatefromwebp($fullPath);
        } else {
            throw new RuntimeException(
                sprintf(
                    'Image creation for type %s not supported',
                    $type
                )
            );
        }

        if ($result === false) {
            throw new RuntimeException(
                sprintf('failed attempt to create image %s', $fullPath)
            );
        } elseif (gettype($result) === 'resource') {
            throw new RuntimeException(
                sprintf(
                    'Image type resurce not expected, failed to create an image from file %s', 
                    $fullPath
            ));
        } else {
            return $result;
        }
    }

    /**
     * @throws RuntimeException
     * @return array<int|string,mixed>
     */
    protected function getDemensionsFromFile(string $filePath): array
    {
        if (! file_exists($filePath) || (! is_readable($filePath))) {
            throw new RuntimeException(sprintf(
                'Image file %s not exist',
                $filePath
            ));
        }

        $dimensions = getimagesize($filePath);
        if ($dimensions === false) {
            throw new RuntimeException('Can\'t determine demensions, image is not valid');
        }
        return $dimensions;
    }

    protected function loadMetaDataFromFile(string $fullPath): Image
    {
        $demensions = $this->getDemensionsfromFile($fullPath);
        return new Image($demensions);
    }

        /**
     * @throws RuntimeException
     */
    protected function saveImageToFile(
        GdImage $data,
        string $fullPath,
        string $type,
        int $quility = 100
    ): void {
        
        try {
            $this->checkGDcapabilities($type());
        } catch(RuntimeException $e) {
            throw new RuntimeException($e->getMessage());
        }

        if ($type === 'webp') {
            $result = imagewebp($data, $fullPath, $quility);
            if ($result === false) {
                throw new RuntimeException(
                    sprintf('Failed to save image to file %s', $fullPath)
                );
            }
        } else {
            throw new RuntimeException(
                sprintf('Image saving for type %s not supported', $type())
            );
        }
    }

    /** @throws RuntimeException */
    protected function saveImageToString(GdImage $image, string $type, int $quality): string
    {
        $result = '';
        if ($type === 'webp') {
            $stream = new TempStream();
            $stream->writeFromCallable('imagewebp', 1, $image, null, $quality);
            $result = $stream();
        } else {
            throw new RuntimeException(
                sprintf(
                    'Image creation for type %s not supported',
                    $type
                )
            );
        }

        return $result;
    }
}