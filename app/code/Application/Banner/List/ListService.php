<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Banner\List;

use Romchik38\Site2\Application\Banner\List\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Banner\List\View\BannerDto;

final class ListService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * List active banners
     *
     * @throws RepositoryException
     * @return array<int,BannerDto>
     * */
    public function list(): array
    {
        return $this->repository->list();
    }
}
