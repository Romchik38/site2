<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImageCache\View;

use InvalidArgumentException;
use Romchik38\Site2\Application\ImageCache\View\Commands\Find\Find;
use Romchik38\Site2\Application\ImageCache\View\Commands\Find\ViewDTO;
use Romchik38\Site2\Application\ImageCache\View\Exceptions\NoSuchImageCacheException;
use Romchik38\Site2\Application\ImageCache\View\Exceptions\RepositoryException;
use Romchik38\Site2\Domain\ImageCache\VO\Key;

final class ViewService
{
    public function __construct(
        protected readonly RepositoryInterface $imageCacheViewRepository
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * @throws NoSuchImageCacheException
     * @throws RepositoryException
     */
    public function getByKey(Find $command): ViewDTO
    {
        $keyVo = new Key($command->key());
        return $this->imageCacheViewRepository->getByKey($keyVo);
    }
}
