<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Banner\AdminList;

use Romchik38\Site2\Application\Banner\AdminList\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Banner\AdminList\View\BannerDto;

interface RepositoryInterface
{
    /**
     * List all banners in the database
     *
     * @throws RepositoryException
     * @return array<int,BannerDto>
     * */
    public function list(): array;
}
