<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImageService;

use Romchik38\Site2\Domain\Image\Entities\Content;

interface CreateContentServiceInterface
{
    /** @throws CouldNotCreateContentException */
    public function createContent(mixed $file): Content;
}
