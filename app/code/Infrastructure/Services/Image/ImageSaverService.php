<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image;

use GdImage;
use Romchik38\Site2\Application\Image\ImageService\CouldNotSaveImageDataException;
use Romchik38\Site2\Application\Image\ImageService\ImageSaverServiceInterface;
use Romchik38\Site2\Domain\Image\VO\Type;

final class ImageSaverService extends AbstractImageServiceUseGd 
    implements ImageSaverServiceInterface
{
    /**
     * @throws CouldNotSaveImageDataException
     */
    public function saveImageToFile(
        GdImage $data,
        string $fullPath,
        Type $type,
        int $quility = 100
    ): void {
        $this->checkGDcapabilities($type());
        if ($type() === 'webp') {
            $result = imagewebp($data, $fullPath, $quility);
            if ($result === false) {
                throw new CouldNotSaveImageDataException(
                    sprintf('Failed to save image to file %s', $fullPath)
                );
            }
        } else {
            throw new CouldNotSaveImageDataException(
                sprintf('Image saving for type %s not supported', $type())
            );
        }
    }
}