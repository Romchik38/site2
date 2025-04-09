<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Filesystem\Image\ImageService;

use Laminas\Diactoros\UploadedFile;
use Romchik38\Site2\Application\Image\ImageService\CouldNotCreateContentException;
use Romchik38\Site2\Application\Image\ImageService\CreateContentServiceInterface;
use Romchik38\Site2\Domain\Image\Entities\Content;
use Romchik38\Site2\Domain\Image\VO\Height;
use Romchik38\Site2\Domain\Image\VO\Size;
use Romchik38\Site2\Domain\Image\VO\Type;
use Romchik38\Site2\Domain\Image\VO\Width;
use Romchik38\Site2\Infrastructure\Persist\Filesystem\Image\AbstractImageStorageUseGd;
use RuntimeException;

use function gettype;
use function sprintf;

final class ImageStorageUseDiactoros extends AbstractImageStorageUseGd implements CreateContentServiceInterface
{
    public function createContent(mixed $file): Content
    {
        if (! $file instanceof UploadedFile) {
            $type = gettype($file);
            if ($type === 'object') {
                $type = $file::class;
            }
            throw new CouldNotCreateContentException(sprintf(
                'Param file is invalid: expected \Laminas\Diactoros\UploadedFile, given %s',
                $type
            ));
        }

        try {
            $stream        = $file->getStream();
            $data          = $stream->getContents();
            $imageMetadata = $this->loadMetaDataFromString($data);
            $image         = $this->createImageFromString($data);
        } catch (RuntimeException $e) {
            throw new CouldNotCreateContentException($e->getMessage());
        }

        $fileSize = $file->getSize();
        if ($fileSize === null) {
            throw new CouldNotCreateContentException('Image creation is failed: cannot determine filesize');
        }

        return new Content(
            $image,
            new Type($imageMetadata->type),
            new Height($imageMetadata->height),
            new Width($imageMetadata->width),
            new Size($fileSize)
        );
    }
}
