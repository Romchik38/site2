<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AuthorService;

use InvalidArgumentException;
use Romchik38\Site2\Application\Language\ListView\ListViewService;
use Romchik38\Site2\Domain\Author\Author;
use Romchik38\Site2\Domain\Author\CouldDeleteException;
use Romchik38\Site2\Domain\Author\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Author\CouldNotSaveException;
use Romchik38\Site2\Domain\Author\DuplicateIdException;
use Romchik38\Site2\Domain\Author\Entities\Translate;
use Romchik38\Site2\Domain\Author\NoSuchAuthorException;
use Romchik38\Site2\Domain\Author\RepositoryException;
use Romchik38\Site2\Domain\Author\RepositoryInterface;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Description;
use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Language\VO\Identifier;

final class AuthorService
{
    public function __construct(
        private readonly RepositoryInterface $repository,
        private readonly ListViewService $languagesService
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * @throws NoSuchAuthorException
     * @throws CouldNotSaveException
     * @throws CouldNotChangeActivityException
     */
    public function update(Update $command): AuthorId
    {
        $name = new Name($command->name);

        if ($command->id !== '') {
            try {
                $authorId = new AuthorId($command->id);
                $model    = $this->repository->getById($authorId);
                $model->reName($name);
            } catch (DuplicateIdException $e) {
                throw new CouldNotSaveException($e->getMessage());
            } catch (RepositoryException $e) {
                throw new CouldNotSaveException($e->getMessage());
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

        $savedModel    = $this->repository->save($model);
        $savedAuthorId = $savedModel->getId();
        if ($savedAuthorId === null) {
            throw new CouldNotSaveException('Author new id not updated');
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
        $authorId = new AuthorId($command->id);

        try {
            $model = $this->repository->getById($authorId);
        } catch (DuplicateIdException $e) {
            throw new CouldDeleteException($e->getMessage());
        } catch (RepositoryException $e) {
            throw new CouldDeleteException($e->getMessage());
        }

        $model->deactivate();

        $this->repository->delete($model);
    }
}
