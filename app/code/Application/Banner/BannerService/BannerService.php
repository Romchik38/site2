<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Banner\BannerService;

use InvalidArgumentException;
use Romchik38\Site2\Application\Banner\BannerService\Commands\Update;
use Romchik38\Site2\Application\Banner\BannerService\Exceptions\CouldNotUpdateException;
use Romchik38\Site2\Application\Banner\BannerService\Exceptions\NoSuchBannerException;
use Romchik38\Site2\Application\Banner\BannerService\Exceptions\RepositoryException;
use Romchik38\Site2\Domain\Banner\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Banner\VO\Identifier as BannerId;
use Romchik38\Site2\Domain\Banner\VO\Name;

final class BannerService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotChangeActivityException
     * @throws CouldNotUpdateException
     * @throws InvalidArgumentException
     * @throws NoSuchBannerException
     */
    public function update(Update $command): void
    {
        $id   = BannerId::fromString($command->id);
        $name = new Name($command->name);

        try {
            $model = $this->repository->getById($id);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        }

        // activity
        if ($command->changeActivity === Update::CHANGE_ACTIVITY_YES_FIELD) {
            if ($model->active === true) {
                $model->deactivate();
            } else {
                $model->activate();
            }
        }

        $model->name = $name;

        try {
            $this->repository->save($model);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        }
    }
}
