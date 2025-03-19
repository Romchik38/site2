<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImageCacheView;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Application\ImageCacheView\View\ImageCacheViewDTO;
use Romchik38\Site2\Application\ImageCacheView\View\ImageCacheViewRepositoryInterface;
use Romchik38\Site2\Domain\ImageCache\VO\Key;

use function sprintf;

final class ImageCacheViewService
{
    public function __construct(
        protected readonly ImageCacheViewRepositoryInterface $imageCacheViewRepository
    ) {
    }

    /** @throws NoSuchImageCacheException */
    public function getByKey(Find $command): ImageCacheViewDTO
    {
        try {
            return $this->imageCacheViewRepository->getByKey(
                new Key($command->key())
            );
        } catch (NoSuchEntityException) {
            throw new NoSuchImageCacheException(
                sprintf(
                    'image with key %s do not present in the cache storage',
                    $command->key()
                )
            );
        }
    }
}
