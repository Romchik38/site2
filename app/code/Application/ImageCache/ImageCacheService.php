<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImageCache;

use Romchik38\Site2\Domain\ImageCache\ImageCache;
use Romchik38\Site2\Domain\ImageCache\ImageCacheRepositoryInterface;
use Romchik38\Site2\Domain\ImageCache\VO\Data;
use Romchik38\Site2\Domain\ImageCache\VO\Key;
use Romchik38\Site2\Domain\ImageCache\VO\Type;

final class ImageCacheService
{
    public function __construct(
        protected readonly ImageCacheRepositoryInterface $imageCacheRepository
    ) {}

    public function save(Cache $command): void
    {
        $imgCache = new ImageCache(
            new Key($command->key),
            new Data($command->data),
            new Type($command->type),
        );

        $this->imageCacheRepository->add($imgCache);
    }

    public function totalCount(): int
    {
        return $this->imageCacheRepository->totalCount();
    }

    public function totalSize(): int
    {
        return $this->imageCacheRepository->totalSize();
    }

    public function totalPrettySize(): string
    {
        return $this->imageCacheRepository->totalPrettySize();
    }
}
