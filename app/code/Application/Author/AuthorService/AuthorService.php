<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AuthorService;

use InvalidArgumentException;
use Romchik38\Site2\Application\Author\AuthorService\Exceptions\CouldDeleteException;
use Romchik38\Site2\Application\Author\AuthorService\Exceptions\CouldNotUpdateException;
use Romchik38\Site2\Application\Author\AuthorService\Exceptions\NoSuchAuthorException;
use Romchik38\Site2\Application\Author\AuthorService\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Language\List\ListService;
use Romchik38\Site2\Domain\Author\Author;
use Romchik38\Site2\Domain\Author\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Author\Entities\Translate;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Description;
use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Language\VO\Identifier;
use Romchik38\Site2\Application\Author\AuthorService\Commands\Delete;
use Romchik38\Site2\Application\Author\AuthorService\Commands\Update;

final class AuthorService
{
    public function __construct(
        private readonly RepositoryInterface $repository,
        private readonly ListService $languagesService
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * @throws NoSuchAuthorException
     * @throws CouldNotUpdateException
     * @throws CouldNotChangeActivityException
     */
    public function update(Update $command): AuthorId
    {
        $name = new Name($command->name);

        if ($command->id !== '') {
            try {
                $authorId = AuthorId::fromString($command->id);
                $model    = $this->repository->getById($authorId);
                $model->reName($name);
            } catch (RepositoryException $e) {
                throw new CouldNotUpdateException($e->getMessage());
            }
        } else {
            $languages = [];
            foreach ($this->languagesService->getAll() as $language) {
                $languages[] = $language->identifier;
            }
            $model = Author::createNew($name, $languages);
        }

        // translates
        foreach ($command->translates as $translate) {
            $model->addTranslate(new Translate(
                new Identifier($translate->language),
                new Description($translate->description)
            ));
        }

        // Activity
        if ($command->changeActivity === Update::CHANGE_ACTIVITY_YES_FIELD) {
            if ($model->isActive()) {
                $model->deactivate();
            } else {
                $model->activate();
            }
        }

        try {
            $savedModel = $this->repository->save($model);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        }
        $savedAuthorId = $savedModel->getId();
        if ($savedAuthorId === null) {
            throw new CouldNotUpdateException('Author new id not updated');
        } else {
            return $savedAuthorId;
        }
    }

    /**
     * @throws InvalidArgumentException
     * @throws CouldDeleteException
     * @throws NoSuchAuthorException
     * @throws CouldNotChangeActivityException
     */
    public function delete(Delete $command): void
    {
        $authorId = AuthorId::fromString($command->id);

        try {
            $model = $this->repository->getById($authorId);
        } catch (RepositoryException $e) {
            throw new CouldDeleteException($e->getMessage());
        }

        $model->deactivate();

        $this->repository->delete($model);
    }
}
