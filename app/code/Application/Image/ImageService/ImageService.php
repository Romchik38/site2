<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImageService;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Image\ImageRepositoryInterface;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Image\RepositoryException;
use Romchik38\Site2\Domain\Image\Entities\Translate;
use Romchik38\Site2\Domain\Image\VO\Description;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Image\VO\Name;
use Romchik38\Site2\Domain\Image\Entities\Author;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Image\NoSuchAuthorException;

final class ImageService
{
    public function __construct(
        private readonly ImageRepositoryInterface $repository
    ) {   
    }

    /** 
     * @throws CouldNotUpdateException
     * @throws CouldNotChangeActivityException
     * @throws InvalidArgumentException
     */
    public function update(Update $command): void
    {
        $imageId = ImageId::fromString($command->id);
        try {
            $model = $this->repository->getById($imageId);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        }

        $model->rename(new Name($command->name));

        // author
        // 1 change key
        if ($command->changeAuthor === Update::CHANGE_ACTIVITY_YES_FIELD) {
            $newAuthorId = new AuthorId($command->changeAuthorId);
            try {
                $author = $this->repository->findAuthor($newAuthorId);
            } catch (NoSuchAuthorException $e) {
                throw new CouldNotUpdateException($e->getMessage());
            } catch (RepositoryException $e) {
                throw new CouldNotUpdateException($e->getMessage());
            } 
            $model->changeAuthor($author);
        }

        // translates
        foreach ($command->translates as $translate) {
            $model->addTranslate(new Translate(
                new LanguageId($translate->language),
                new Description($translate->description)
            ));
        }
        // activity
        if ($command->changeActivity === Update::CHANGE_ACTIVITY_YES_FIELD) {
            if ($model->isActive()) {
                $model->deactivate();
            } else {
                /** @todo load content */
                $model->activate();
            }
        }

        /** @todo load content */
        // do update


    }
}
