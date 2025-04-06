<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image;

use Romchik38\Site2\Application\Image\ImageService\CreateContentServiceInterface;
use Romchik38\Site2\Domain\Image\Entities\Content;
use Romchik38\Site2\Application\Image\ImageService\CouldNotCreateContentException;

final class CreateContentServiceUseDiactoros implements CreateContentServiceInterface
{
    public function createContent(mixed $file): Content
    {
        /** @todo test */
        if (! $file instanceof \Laminas\Diactoros\UploadedFile) {
            $type = gettype($file);
            if ($type === 'object') {
                $type = get_class($file);
            }
            throw new CouldNotCreateContentException(sprintf(
                'Param file is invalid: expected \Laminas\Diactoros\UploadedFile, given %s',
                $type
            ));
        }

        $stream = $file->getStream();
        $data = $stream->getContents();


        $d = getimagesizefromstring($data);

        $i = imagecreatefromstring($data);
    }
}
