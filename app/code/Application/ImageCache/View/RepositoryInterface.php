<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImageCache\View;

use Romchik38\Site2\Application\ImageCache\View\Commands\Find\ViewDTO;
use Romchik38\Site2\Application\ImageCache\View\Exceptions\NoSuchImageCacheException;
use Romchik38\Site2\Application\ImageCache\View\Exceptions\RepositoryException;
use Romchik38\Site2\Domain\ImageCache\VO\Key;

interface RepositoryInterface
{
    /**
     * @throws NoSuchImageCacheException
     * @throws RepositoryException - On any database/structure errors.
     */
    public function getByKey(Key $key): ViewDTO;
}
