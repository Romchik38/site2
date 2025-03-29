<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImageCacheView\View;

use Romchik38\Site2\Application\ImageCacheView\NoSuchImageCacheException;
use Romchik38\Site2\Application\ImageCacheView\RepositoryException;
use Romchik38\Site2\Domain\ImageCache\VO\Key;

interface ImageCacheViewRepositoryInterface
{
    /**
     * @throws NoSuchImageCacheException
     * @throws RepositoryException - On any database/structure errors.
     */
    public function getByKey(Key $key): ImageCacheViewDTO;
}
