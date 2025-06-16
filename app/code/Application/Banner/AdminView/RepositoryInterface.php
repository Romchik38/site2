<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Banner\AdminView;

use Romchik38\Site2\Application\Banner\AdminView\Exceptions\NoSuchBannerException;
use Romchik38\Site2\Application\Banner\AdminView\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Banner\AdminView\View\BannerDto;
use Romchik38\Site2\Domain\Banner\VO\Identifier as BannerId;

interface RepositoryInterface
{
    /**
     * @throws NoSuchBannerException
     * @throws RepositoryException
     * */
    public function find(BannerId $id): BannerDto;
}
