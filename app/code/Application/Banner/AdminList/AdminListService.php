<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Banner\AdminList;

use Romchik38\Site2\Application\Banner\AdminList\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Banner\AdminList\View\BannerDto;

final class AdminListService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws RepositoryException
     * @return array<int,BannerDto>
     * */
    public function list(): array
    {
        return $this->repository->list();
    }
}
