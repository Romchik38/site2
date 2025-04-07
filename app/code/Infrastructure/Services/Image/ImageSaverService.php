<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image;

use GdImage;
use Romchik38\Site2\Application\Image\ImageService\ImageSaverServiceInterface;
use Romchik38\Site2\Domain\Image\VO\Type;

final class ImageSaverService implements ImageSaverServiceInterface
{
    /**
     * @throws CouldNotSaveImageDataException
     */
    public function saveImageToFile(
        GdImage $data,
        string $fullPath,
        Type $type
    ): void {
        
    }
}