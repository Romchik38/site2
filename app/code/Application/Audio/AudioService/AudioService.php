<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AudioService;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Audio\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Audio\VO\Id;
use Romchik38\Site2\Domain\Audio\VO\Name;

final class AudioService
{
    public function __construct(
        private readonly RepositoryInterface $repository,
        private readonly AudioStorageInterface $audioStorage
    ) {
    }

    /**
     * @throws CouldNotChangeActivityException
     * @throws CouldNotUpdateException
     * @throws InvalidArgumentException
     * @throws NoSuchAudioException
     */
    public function update(Update $command): void
    {
        $id = Id::fromString($command->id);

        try {
            $model = $this->repository->getById($id);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        }

        $name = new Name($command->name);
        $model->reName($name);

        // activity
        if ($command->changeActivity === Update::CHANGE_ACTIVITY_YES_FIELD) {
            if ($model->isActive()) {
                $model->deactivate();
            } else {
                $translates = $model->getTranslates();
                foreach ($translates as $translate) {
                    try {
                        $content = $this->audioStorage->load($translate->getPath());
                        $translate->loadContent($content);
                    } catch (CouldNotLoadAudioDataException $e) {
                        throw new CouldNotUpdateException($e->getMessage());
                    }
                }
                $model->activate();
            }
        }

        try {
            $this->repository->save($model);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        }
    }
}
