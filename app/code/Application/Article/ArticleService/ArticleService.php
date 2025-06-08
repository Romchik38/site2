<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleService;

use Romchik38\Site2\Application\Article\ArticleService\Commands\Update;
use Romchik38\Site2\Application\Article\ArticleService\Exceptions\{
    CouldNotCreateException,
    CouldNotDeleteException,
    CouldNotUpdateException,
    NoSuchArticleException,
    RepositoryException
};
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Article\Entities\Translate;
use DateTime;
use Romchik38\Site2\Domain\Article\VO\Description;
use Romchik38\Site2\Domain\Article\VO\Name;
use Romchik38\Site2\Domain\Article\VO\ShortDescription;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;

final class ArticleService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @todo test all paths
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
            $existingTranslate = $model->getTranslate($translate->language);
            $language          = new LanguageId($translate->language);
            $name              = new Name($translate->name);
            $shortDescription  = new ShortDescription($translate->shortDescription);
            $description       = new Description($translate->description);
            if ($existingTranslate === null) {
                $createdAt = new DateTime();
                $updatedAt = new DateTime();
            } else {
                $createdAt = $existingTranslate->createdAt;
                $updatedAt = $existingTranslate->updatedAt;
                if (
                    $translate->name !== ($existingTranslate->name)() ||
                    $translate->shortDescription !== ($existingTranslate->shortDescription)() ||
                    $translate->description !== ($existingTranslate->description)()
                ) {
                    $updatedAt = new DateTime();
                }
            }
            $model->addTranslate(new Translate(
                $language,
                $name,
                $shortDescription,
                $description,
                $createdAt,
                $updatedAt
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
            $authorId = new AuthorId($command->authorId);
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
        $categories = [];
        foreach ($command->categories as $category) {
            $categories[] = new CategoryId($category);
        }

        $model;
    }
}
