<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\CategoryService;

use InvalidArgumentException;
use Romchik38\Site2\Application\Category\CategoryService\Commands\Create;
use Romchik38\Site2\Application\Category\CategoryService\Commands\Update;
use Romchik38\Site2\Application\Category\CategoryService\Exceptions\CouldNotCreateException;
use Romchik38\Site2\Application\Category\CategoryService\Exceptions\CouldNotUpdateException;
use Romchik38\Site2\Application\Category\CategoryService\Exceptions\NoSuchCategoryException;
use Romchik38\Site2\Application\Category\CategoryService\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Language\ListView\ListViewService;
use Romchik38\Site2\Application\Language\ListView\RepositoryException as LanguageRepositoryException;
use Romchik38\Site2\Domain\Category\Category;
use Romchik38\Site2\Domain\Category\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Category\Entities\Translate;
use Romchik38\Site2\Domain\Category\VO\Description;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Category\VO\Name;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class CategoryService
{
    public function __construct(
        private readonly RepositoryInterface $repository,
        private readonly ListViewService $languagesService
    ) {
    }

    /**
     * @throws CouldNotCreateException
     * @throws InvalidArgumentException
     */
    public function create(Create $command): CategoryId
    {
        $id = new CategoryId($command->id);

        try {
            $languages = [];
            foreach ($this->languagesService->getAll() as $language) {
                $languages[] = $language->identifier;
            }
        } catch (LanguageRepositoryException $e) {
            throw new CouldNotCreateException($e->getMessage());
        }

        // translates
        $translates = [];
        foreach ($command->translates as $translate) {
            $translates[] = new Translate(
                new LanguageId($translate->language),
                new Description($translate->description),
                new Name($translate->name)
            );
        }

        $model = Category::create(
            $id,
            $languages,
            $translates
        );

        try {
            return $this->repository->add($model);
        } catch (RepositoryException $e) {
            throw new CouldNotCreateException($e->getMessage());
        }
    }

    /**
     * @throws CouldNotChangeActivityException
     * @throws CouldNotUpdateException
     * + @throws InvalidArgumentException
     * @throws NoSuchCategoryException
     */
    public function update(Update $command): void
    {
        $id = new CategoryId($command->id);

        try {
            $model = $this->repository->getById($id);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        }

        // translates
        foreach ($command->translates as $translate) {
            $model->addTranslate(new Translate(
                new LanguageId($translate->language),
                new Description($translate->description),
                new Name($translate->name),
            ));
        }

        /** @todo check on fresh category, must throw error on empty articles list (add) */
        // activity
        if ($command->changeActivity === Update::CHANGE_ACTIVITY_YES_FIELD) {
            if ($model->isActive()) {
                $model->deactivate();
            } else {
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
