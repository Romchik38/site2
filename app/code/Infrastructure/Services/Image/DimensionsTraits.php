<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image;

use RuntimeException;

trait DimensionsTraits
{

    /**
     * @throws RuntimeException
     * @return array<int|string,mixed>
     */
    public function fromFilePath(string $filePath): array
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
}
