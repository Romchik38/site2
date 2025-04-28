<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImageCache\ImageCacheService;

use Romchik38\Site2\Application\ImageCache\ImageCacheService\Exceptions\RepositoryException;
use Romchik38\Site2\Domain\ImageCache\ImageCache;

interface RepositoryInterface
{
    /** @throws RepositoryException */
    public function add(ImageCache $model): void;

    /**
     * Returns count of images in a storage
     *
     * @throws RepositoryException
     * */
    public function totalCount(): int;

    /**
     * total storage size in bytes
     *
     * @throws RepositoryException
     * */
    public function totalSize(): int;

    /**
     * total storage size in kB, MB, GB, or TB
     *
     * @throws RepositoryException
     * */
    public function totalPrettySize(): string;

    /**
     * Delete all data
     *
     * @throws RepositoryException
     * */
    public function deleteAll(): void;
}
