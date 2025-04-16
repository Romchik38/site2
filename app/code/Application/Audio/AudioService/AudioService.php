<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AudioService;

use InvalidArgumentException;
use Romchik38\Site2\Application\Language\ListView\ListViewService;
use Romchik38\Site2\Application\Language\ListView\RepositoryException as LanguageRepositoryException;
use Romchik38\Site2\Domain\Audio\Audio;
use Romchik38\Site2\Domain\Audio\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Audio\VO\Id;
use Romchik38\Site2\Domain\Audio\VO\Name;

final class AudioService
{
    public function __construct(
        private readonly RepositoryInterface $repository,
        private readonly AudioStorageInterface $audioStorage,
        private readonly ListViewService $languagesService
    ) {
    }

    /**
     * @throws CouldNotCreateException
     * @throws InvalidArgumentException
     */
    public function create(Create $command): Id
    {
        $name = new Name($command->name);

        try {
            $languages = [];
            foreach ($this->languagesService->getAll() as $language) {
                $languages[] = $language->identifier;
            }
        } catch (LanguageRepositoryException $e) {
            throw new CouldNotCreateException($e->getMessage());
        }

        $model = Audio::create(
            $name,
            $languages
        );

        try {
            $addedModel = $this->repository->add($model);
        } catch (RepositoryException $e) {
            throw new CouldNotCreateException($e->getMessage());
        }

        return $addedModel->getId();
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

        /** @todo diactivate on test audio */
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
