<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image;

use Laminas\Diactoros\UploadedFile;
use Romchik38\Site2\Application\Image\ImageService\CouldNotCreateContentException;
use Romchik38\Site2\Application\Image\ImageService\CreateContentServiceInterface;
use Romchik38\Site2\Domain\Image\Entities\Content;
use Romchik38\Site2\Domain\Image\VO\Height;
use Romchik38\Site2\Domain\Image\VO\Size;
use Romchik38\Site2\Domain\Image\VO\Type;
use Romchik38\Site2\Domain\Image\VO\Width;
use RuntimeException;

use function gettype;
use function imagecreatefromstring;
use function sprintf;

final class CreateContentServiceUseDiactoros extends AbstractImageStorageUseGd implements CreateContentServiceInterface
{
    public function createContent(mixed $file): Content
    {
        /** @todo test */
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

        $stream = $file->getStream();
        $data   = $stream->getContents();

        try {
            $imageMetadata = $this->loadMetaDataFromString($data);
        } catch (RuntimeException $e) {
            throw new CouldNotCreateContentException($e->getMessage());
        }

        $image = imagecreatefromstring($data);
        if ($image === false || gettype($image) === 'resource') {
            throw new CouldNotCreateContentException('Image creation aborted: type not GdImage');
        }

        return new Content(
            $image,
            new Type($imageMetadata->type),
            new Height($imageMetadata->height),
            new Width($imageMetadata->width),
            new Size($file->getSize())
        );
    }
}
