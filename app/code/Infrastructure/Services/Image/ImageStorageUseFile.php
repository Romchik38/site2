<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image;

use GdImage;
use Romchik38\Site2\Application\Image\ImageService\CouldNotSaveImageDataException;
use Romchik38\Site2\Application\Image\ImageService\ImageStorageInterface;
use Romchik38\Site2\Domain\Image\Entities\Content;
use Romchik38\Site2\Domain\Image\VO\Path;
use RuntimeException;

final class ImageStorageUseFile extends AbstractImageStorageUseGd 
    implements ImageStorageInterface
{

    public function __construct(
        private readonly string $imageBackendPath
    ) {
    }

    /**
     * @throws CouldNotSaveImageDataException
     */
    public function save(Content $content, Path $path): void
    {
        $fullPath = sprintf(
            '%s/%s',
            $this->imageBackendPath,
            $path()
        );

        $type = $content->getType();

        try {
            $this->saveImageToFile(
                $content->getData(),
                $fullPath,
                $type()
            );
        } catch (RuntimeException $e) {
            throw new CouldNotSaveImageDataException($e->getMessage());
        }
    }
}