<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Banner\AdminView;

use InvalidArgumentException;
use Romchik38\Site2\Application\Banner\AdminView\Exceptions\CouldNotFindException;
use Romchik38\Site2\Application\Banner\AdminView\Exceptions\NoSuchBannerException;
use Romchik38\Site2\Application\Banner\AdminView\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Banner\AdminView\View\BannerDto;
use Romchik38\Site2\Domain\Banner\VO\Identifier as BannerId;

final class AdminView
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotFindException
     * @throws InvalidArgumentException
     * @throws NoSuchBannerException
     * @throws RepositoryException
     * */
    public function find(string $id): BannerDto
    {
        $bannerId = BannerId::fromString($id);

        try {
            return $this->repository->find($bannerId);
        } catch (RepositoryException $e) {
            throw new CouldNotFindException($e->getMessage());
        }
    }
}
