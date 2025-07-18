<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImageCache\ImageCacheService;

use InvalidArgumentException;
use Romchik38\Site2\Application\ImageCache\ImageCacheService\Commands\Create;
use Romchik38\Site2\Application\ImageCache\ImageCacheService\Exceptions\CouldNotSaveException;
use Romchik38\Site2\Application\ImageCache\ImageCacheService\Exceptions\RepositoryException;
use Romchik38\Site2\Domain\ImageCache\ImageCache;
use Romchik38\Site2\Domain\ImageCache\VO\Data;
use Romchik38\Site2\Domain\ImageCache\VO\Key;
use Romchik38\Site2\Domain\ImageCache\VO\Type;

final class ImageCacheService
{
    public function __construct(
        private readonly RepositoryInterface $imageCacheRepository
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * @throws CouldNotSaveException
     */
    public function create(Create $command): void
    {
        $imgCache = ImageCache::create(
            new Key($command->key),
            new Data($command->data),
            new Type($command->type),
        );
        try {
            $this->imageCacheRepository->add($imgCache);
        } catch (RepositoryException $e) {
            throw new CouldNotSaveException($e->getMessage());
        }
    }

    /** @throws RepositoryException */
    public function totalCount(): int
    {
        return $this->imageCacheRepository->totalCount();
    }

    /** @throws RepositoryException */
    public function totalSize(): int
    {
        return $this->imageCacheRepository->totalSize();
    }

    /** @throws RepositoryException */
    public function totalPrettySize(): string
    {
        return $this->imageCacheRepository->totalPrettySize();
    }

    /** @throws RepositoryException */
    public function clear(): void
    {
        $this->imageCacheRepository->deleteAll();
    }
}
