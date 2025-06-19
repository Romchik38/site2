<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Banner\List;

use Romchik38\Site2\Application\Banner\List\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Banner\List\View\BannerDto;

interface RepositoryInterface
{
    /**
     * List active banners in the database
     *
     * @throws RepositoryException
     * @return array<int,BannerDto>
     * */
    public function list(): array;
}
