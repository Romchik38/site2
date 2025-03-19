<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImageCacheView\View;

use Romchik38\Site2\Domain\ImageCache\DuplicateKeyException;
use Romchik38\Site2\Domain\ImageCache\VO\Key;

interface ImageCacheViewRepositoryInterface
{
    /**
     * @throws DuplicateKeyException - On duplicates.
     */
    public function getByKey(Key $key): ImageCacheViewDTO;
}
