<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Banner\BannerService;

use Romchik38\Site2\Application\Banner\BannerService\Exceptions\NoSuchBannerException;
use Romchik38\Site2\Application\Banner\BannerService\Exceptions\RepositoryException;
use Romchik38\Site2\Domain\Banner\Banner;
use Romchik38\Site2\Domain\Banner\Entities\Image;
use Romchik38\Site2\Domain\Banner\VO\Identifier as BannerId;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;

interface RepositoryInterface
{
    /** @throws RepositoryException */
    public function add(Banner $model): BannerId;

    /** @throws RepositoryException */
    public function delete(Banner $model): void;

    /** @throws RepositoryException */
    public function createImage(ImageId $id): Image;

    /**
     * @throws NoSuchBannerException
     * @throws RepositoryException
     */
    public function getById(BannerId $id): Banner;

    /** @throws RepositoryException */
    public function save(Banner $model): void;
}
