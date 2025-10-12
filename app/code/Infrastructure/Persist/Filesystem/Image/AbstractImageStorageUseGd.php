<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Filesystem\Image;

use GdImage;
use InvalidArgumentException;
use Romchik38\Server\Utils\Streams\TempStream;
use RuntimeException;

use function extension_loaded;
use function file_exists;
use function filesize;
use function gd_info;
use function getimagesize;
use function getimagesizefromstring;
use function imagecreatefromstring;
use function imagecreatefromwebp;
use function imagewebp;
use function is_readable;
use function ob_get_clean;
use function ob_start;
use function sprintf;
use function strlen;
use function unlink;

abstract class AbstractImageStorageUseGd
{
    /** @var array<string,string> $capabilities */
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
            throw new RuntimeException(sprintf('Type %s not supported by image storage', $type));
        }
        $capability = $info[$key] ?? null;
        if ($capability === null) {
            throw new RuntimeException(
                sprintf(
                    'Image storage internal error. Capability %s is expected, but not found',
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
        }
        return $result;
    }

    /** @throws RuntimeException */
    protected function createImageFromString(string $data): GdImage
    {
        $image = imagecreatefromstring($data);
        if ($image === false) {
            throw new RuntimeException('Image creation from string is failed');
        }
        return $image;
    }

    /**
     * Removes a file from the file system
     *
     * @throws RuntimeException
     */
    protected function deleteFile(string $fullPath): void
    {
        ob_start();
        $result   = unlink($fullPath);
        $flushVar = ob_get_clean();
        if ($result === false) {
            $message = sprintf('File %s was not deleted', $fullPath);
            if ($flushVar !== false) {
                $message = $flushVar;
            }
            throw new RuntimeException($message);
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

    /**
     * @throws RuntimeException
     * @return array<int|string,mixed>
     */
    protected function getDemensionsFromString(string $data): array
    {
        $dimensions = getimagesizefromstring($data);
        if ($dimensions === false) {
            throw new RuntimeException('Can\'t determine demensions, image is not valid');
        }
        return $dimensions;
    }

    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * */
    protected function loadMetaDataFromFile(string $fullPath): Image
    {
        $demensions = $this->getDemensionsfromFile($fullPath);
        $size       = filesize($fullPath);
        if ($size === false) {
            throw new RuntimeException(sprintf(
                'Cannot determine filesize of %s',
                $fullPath
            ));
        }
        try {
            $image = new Image($demensions, $size);
        } catch (InvalidArgumentException $e) {
            throw new RuntimeException($e->getMessage());
        }
        return $image;
    }

    /** @throws RuntimeException */
    protected function loadMetaDataFromString(string $data): Image
    {
        $demensions = $this->getDemensionsFromString($data);
        $size       = strlen($data);
        try {
            $image = new Image($demensions, $size);
        } catch (InvalidArgumentException $e) {
            throw new RuntimeException($e->getMessage());
        }
        return $image;
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
            $this->checkGDcapabilities($type);
        } catch (RuntimeException $e) {
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
                sprintf('Image saving for type %s not supported', $type)
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
