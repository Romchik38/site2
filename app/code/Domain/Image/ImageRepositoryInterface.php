<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image;

use Romchik38\Site2\Domain\Image\VO\Id;

interface ImageRepositoryInterface
{
    /** @throws NoSuchImageException */
    public function getById(Id $id): Image;
}
