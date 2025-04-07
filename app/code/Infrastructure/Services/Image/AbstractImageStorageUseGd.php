<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image;

use GdImage;
use RuntimeException;

abstract class AbstractImageStorageUseGd
{
    /**
     * Must be in sinc with Image Type
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
}