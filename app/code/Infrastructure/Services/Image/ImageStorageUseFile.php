<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image;

use Romchik38\Site2\Application\Image\ImageService\CouldNotLoadImageDataException;
use Romchik38\Site2\Application\Image\ImageService\CouldNotSaveImageDataException;
use Romchik38\Site2\Application\Image\ImageService\ImageStorageInterface;
use Romchik38\Site2\Domain\Image\Entities\Content;
use Romchik38\Site2\Domain\Image\VO\Path;
use Romchik38\Site2\Domain\Image\VO\Type;
use RuntimeException;

/** @todo move to persist */
final class ImageStorageUseFile extends AbstractImageStorageUseGd 
    implements ImageStorageInterface
{

    public function __construct(
        private readonly string $imageBackendPath
    ) {
    }


    /**
     * @throws CouldNotLoadImageDataException
    */
    public function load(Path $path, Type $type): Content
    {
        try {
            $data = $this->createImageFromFile(
                $this->createFullPath($path),
                $type()
            );
        } catch (RuntimeException $e) {
            throw new CouldNotLoadImageDataException($e->getMessage());
        }

        
    }

    /**
     * @throws CouldNotSaveImageDataException
     */
    public function save(Content $content, Path $path): void
    {
        $type = $content->getType();

        try {
            $this->saveImageToFile(
                $content->getData(),
                $this->createFullPath($path),
                $type()
            );
        } catch (RuntimeException $e) {
            throw new CouldNotSaveImageDataException($e->getMessage());
        }
    }

    private function createFullPath(Path $path): string
    {
        return sprintf(
            '%s/%s',
            $this->imageBackendPath,
            $path()
        );
    }
}