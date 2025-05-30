<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Filesystem\Image\ImageService;

use InvalidArgumentException;
use Romchik38\Site2\Application\Image\ImageService\CouldNotDeleteImageDataException;
use Romchik38\Site2\Application\Image\ImageService\CouldNotLoadImageDataException;
use Romchik38\Site2\Application\Image\ImageService\CouldNotSaveImageDataException;
use Romchik38\Site2\Application\Image\ImageService\ImageStorageInterface;
use Romchik38\Site2\Domain\Image\Entities\Content;
use Romchik38\Site2\Domain\Image\VO\Height;
use Romchik38\Site2\Domain\Image\VO\Path;
use Romchik38\Site2\Domain\Image\VO\Size;
use Romchik38\Site2\Domain\Image\VO\Type;
use Romchik38\Site2\Domain\Image\VO\Width;
use Romchik38\Site2\Infrastructure\Persist\Filesystem\Image\AbstractImageStorageUseGd;
use RuntimeException;

use function sprintf;

final class ImageStorageUseFile extends AbstractImageStorageUseGd implements ImageStorageInterface
{
    public function __construct(
        private readonly string $imageBackendPath
    ) {
    }

    /**
     * @throws CouldNotLoadImageDataException
     */
    public function load(Path $path): Content
    {
        $fullPath = $this->createFullPath($path);

        try {
            $metadata = $this->loadMetaDataFromFile($fullPath);
        } catch (RuntimeException $e) {
            throw new CouldNotLoadImageDataException($e->getMessage());
        }

        try {
            $data = $this->createImageFromFile($fullPath, $metadata->type);
        } catch (RuntimeException $e) {
            throw new CouldNotLoadImageDataException($e->getMessage());
        }

        try {
            $content = new Content(
                $data,
                new Type($metadata->type),
                new Height($metadata->height),
                new Width($metadata->width),
                new Size($metadata->size)
            );
        } catch (InvalidArgumentException $e) {
            throw new CouldNotLoadImageDataException($e->getMessage());
        }

        return $content;
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

    /**
     * @throws CouldNotDeleteImageDataException
     */
    public function deleteByPath(Path $path): void
    {
        $fullPath = $this->createFullPath($path);
        try {
            $this->deleteFile($fullPath);
        } catch (RuntimeException $e) {
            throw new CouldNotDeleteImageDataException($e->getMessage());
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
