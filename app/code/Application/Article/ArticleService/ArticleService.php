<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleService;

use InvalidArgumentException;
use Romchik38\Site2\Application\Article\ArticleService\Commands\Create;
use Romchik38\Site2\Application\Article\ArticleService\Commands\Delete;
use Romchik38\Site2\Application\Article\ArticleService\Commands\Update;
use Romchik38\Site2\Application\Article\ArticleService\Exceptions\CouldNotCreateException;
use Romchik38\Site2\Application\Article\ArticleService\Exceptions\CouldNotDeleteException;
use Romchik38\Site2\Application\Article\ArticleService\Exceptions\CouldNotUpdateException;
use Romchik38\Site2\Application\Article\ArticleService\Exceptions\NoSuchArticleException;
use Romchik38\Site2\Application\Article\ArticleService\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Language\List\Exceptions\RepositoryException as LanguageRepositoryException;
use Romchik38\Site2\Application\Language\List\ListService as LanguageListService;
use Romchik38\Site2\Domain\Article\Article;
use Romchik38\Site2\Domain\Article\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Article\Entities\Translate;
use Romchik38\Site2\Domain\Article\VO\Description;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Name;
use Romchik38\Site2\Domain\Article\VO\ShortDescription;
use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class ArticleService
{
    public function __construct(
        private readonly RepositoryInterface $repository,
        private readonly LanguageListService $languagesService
    ) {
    }

    /**
     * @throws CouldNotCreateException
     * @throws InvalidArgumentException
     */
    public function create(Create $command): void
    {
        $id       = new ArticleId($command->id);
        $authorId = AuthorId::fromString($command->authorId);

        try {
            $author = $this->repository->findAuthor($authorId);
        } catch (RepositoryException $e) {
            throw new CouldNotCreateException($e->getMessage());
        }

        try {
            $languages = [];
            foreach ($this->languagesService->getAll() as $language) {
                $languages[] = $language->identifier;
            }
        } catch (LanguageRepositoryException $e) {
            throw new CouldNotCreateException($e->getMessage());
        }

        $model = Article::create($id, $author, $languages);

        try {
            $this->repository->add($model);
        } catch (RepositoryException $e) {
            throw new CouldNotCreateException($e->getMessage());
        }
    }

    /**
     * @throws CouldNotChangeActivityException
     * @throws CouldNotDeleteException
     * @throws InvalidArgumentException
     * @throws NoSuchArticleException
     */
    public function delete(Delete $command): void
    {
        $id = new ArticleId($command->id);

        try {
            $model = $this->repository->getById($id);
        } catch (RepositoryException $e) {
            throw new CouldNotDeleteException($e->getMessage());
        }

        $model->deactivate();

        try {
            $this->repository->delete($model);
        } catch (RepositoryException $e) {
            throw new CouldNotDeleteException($e->getMessage());
        }
    }

    /**
     * @throws CouldNotChangeActivityException
     * @throws CouldNotUpdateException
     * @throws InvalidArgumentException
     * @throws NoSuchArticleException
     */
    public function update(Update $command): void
    {
        $id = new ArticleId($command->id);

        try {
            $model = $this->repository->getById($id);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        }

        // translates
        foreach ($command->translates as $translate) {
            $language         = new LanguageId($translate->language);
            $name             = new Name($translate->name);
            $shortDescription = new ShortDescription($translate->shortDescription);
            $description      = new Description($translate->description);
            $model->addTranslate(new Translate(
                $language,
                $name,
                $shortDescription,
                $description
            ));
        }

        // Image
        if ($command->imageId !== '') {
            $imageId = ImageId::fromString($command->imageId);
            try {
                $image = $this->repository->createImage($imageId);
            } catch (RepositoryException $e) {
                throw new CouldNotUpdateException($e->getMessage());
            }
            $model->changeImage($image);
        }

        // Author
        if ($command->authorId !== '') {
            $authorId = AuthorId::fromString($command->authorId);
            try {
                $author = $this->repository->findAuthor($authorId);
            } catch (RepositoryException $e) {
                throw new CouldNotUpdateException($e->getMessage());
            }
            $model->changeAuthor($author);
        }

        // Audio
        if ($command->audioId !== '') {
            $audioId = AudioId::fromString($command->audioId);
            try {
                $audio = $this->repository->createAudio($audioId);
            } catch (RepositoryException $e) {
                throw new CouldNotUpdateException($e->getMessage());
            }
            $model->changeAudio($audio);
        }

        // Categories
        $categoryIds = [];
        foreach ($command->categories as $category) {
            $categoryIds[] = new CategoryId($category);
        }

        try {
            $categories = $this->repository->createCategories($categoryIds);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        }
        $model->changeCategories($categories);

        // Activity
        if ($command->changeActivity === Update::CHANGE_ACTIVITY_YES_FIELD) {
            if ($model->active) {
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
