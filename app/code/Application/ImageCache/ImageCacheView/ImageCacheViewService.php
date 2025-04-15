<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImageCache\ImageCacheView;

use InvalidArgumentException;
use Romchik38\Site2\Application\ImageCache\ImageCacheView\View\ImageCacheViewDTO;
use Romchik38\Site2\Application\ImageCache\ImageCacheView\View\ImageCacheViewRepositoryInterface;
use Romchik38\Site2\Domain\ImageCache\VO\Key;

final class ImageCacheViewService
{
    public function __construct(
        protected readonly ImageCacheViewRepositoryInterface $imageCacheViewRepository
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * @throws NoSuchImageCacheException
     * @throws RepositoryException
     */
    public function getByKey(Find $command): ImageCacheViewDTO
    {
        $keyVo = new Key($command->key());
        return $this->imageCacheViewRepository->getByKey($keyVo);
    }
}
