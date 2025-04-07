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
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Image\NoSuchAuthorException;
use Romchik38\Site2\Domain\Image\Image;
use Romchik38\Site2\Domain\Image\VO\Path;
use Romchik38\Site2\Application\Language\ListView\ListViewService;
use Romchik38\Site2\Application\Language\ListView\RepositoryException as LanguageRepositoryException;

final class ImageService
{
    public function __construct(
        private readonly ImageRepositoryInterface $repository,
        private readonly CreateContentServiceInterface $contentService,
        private readonly ListViewService $languagesService,
        private readonly ImageStorageInterface $imageStorage
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
        try {
            $this->repository->save($model);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        }
    }

    /**
     * @todo test
     * 
     * @throws CouldNotCreateException
     * @throws InvalidArgumentException
     */
    public function create(Create $command): ImageId
    {
        try {
            $content = $this->contentService->createContent($command->file);
        } catch (CouldNotCreateContentException $e) {
            throw new CouldNotCreateException($e->getMessage());
        }
        
        $authorId = new AuthorId($command->authorId);

        try {
            $author = $this->repository->findAuthor($authorId);
        } catch (NoSuchAuthorException $e) {
            throw new CouldNotCreateException($e->getMessage());
        } catch (RepositoryException $e) {
            throw new CouldNotCreateException($e->getMessage());
        }

        $path = sprintf(
            '%s/%s.%s',
            $command->folder,
            $this->generateRandomString(20),
            ($content->getType())()
        );

        try {
            $languages = [];
            foreach ($this->languagesService->getAll() as $language) {
                $languages[] = $language->identifier;
            }
        } catch(LanguageRepositoryException $e) {
            throw new CouldNotCreateException($e->getMessage());
        }

        // translates
        $translates = [];
        foreach ($command->translates as $translate) {
            $translates[] = new Translate(
                new LanguageId($translate->language),
                new Description($translate->description)
            );
        }
        
        $model = Image::create(
            new Name($command->name),
            $author,
            new Path($path),
            $languages,
            $translates
        );

        $model->loadContent($content);

        /** add to repository */
        try {
            $addedModel = $this->repository->add($model);
        } catch(RepositoryException $e) {
            throw new CouldNotCreateException($e->getMessage());
        }

        /** save image */
        try {
            $this->imageStorage->save($content, $addedModel->getPath());
        } catch (CouldNotSaveImageDataException $e) {
            /** delete from database */
            try {
                $this->repository->deleteById($addedModel->getId());
            } catch (RepositoryException $e) {
                throw new CouldNotCreateException($e->getMessage()); 
            } 
            
            throw new CouldNotCreateException($e->getMessage());
        }

        return $addedModel->getId();
    }

    private function generateRandomString($length = 10): string {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomString;
    }
}
