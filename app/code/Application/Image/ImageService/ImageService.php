<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImageService;

use InvalidArgumentException;
use Romchik38\Site2\Application\Language\ListView\ListViewService;
use Romchik38\Site2\Application\Language\ListView\RepositoryException as LanguageRepositoryException;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Image\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Image\Entities\Translate;
use Romchik38\Site2\Domain\Image\Image;
use Romchik38\Site2\Domain\Image\ImageRepositoryInterface;
use Romchik38\Site2\Domain\Image\NoSuchAuthorException;
use Romchik38\Site2\Domain\Image\NoSuchImageException;
use Romchik38\Site2\Domain\Image\RepositoryException;
use Romchik38\Site2\Domain\Image\VO\Description;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Image\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Path;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function in_array;
use function random_int;
use function sprintf;
use function strlen;

final class ImageService
{
    public const CONTENT_NAME_LENGTH = 20;

    public function __construct(
        private readonly ImageRepositoryInterface $repository,
        private readonly CreateContentServiceInterface $contentService,
        private readonly ListViewService $languagesService,
        private readonly ImageStorageInterface $imageStorage
    ) {
    }

    /**
     * Update existing image model
     * do 1 transaction:
     *   - updates data in the database
     *
     * @throws CouldNotUpdateException
     * @throws CouldNotChangeActivityException
     * @throws InvalidArgumentException
     * @throws NoSuchImageException
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
                try {
                    $content = $this->imageStorage->load($model->getPath());
                    $model->loadContent($content);
                    $model->activate();
                } catch (CouldNotLoadImageDataException $e) {
                    throw new CouldNotUpdateException($e->getMessage());
                }
            }
        }

        // do update
        try {
            $this->repository->save($model);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        }
    }

    /**
     * Create new image model
     * do 2 transactions:
     *   - adds new data to the database
     *   - saves content on the filesystem
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

        $folder = $command->folder;
        if (! in_array($folder, Create::ALLOWED_FOLDERS)) {
            throw new CouldNotCreateException(sprintf(
                'image folder %s is not allowed',
                $folder
            ));
        }

        $path = sprintf(
            '%s/%s.%s',
            $folder,
            $this->generateRandomString($this::CONTENT_NAME_LENGTH),
            ($content->getType())()
        );

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

        /** 1 transaction add to the repository */
        try {
            $addedModel   = $this->repository->add($model);
            $addedImageId = $addedModel->getId();
            if ($addedImageId === null) {
                throw new CouldNotCreateException('Image id was not updated while creating');
            } else {
                /** 2 transaction - save the image */
                try {
                    $this->imageStorage->save($content, $addedModel->getPath());
                } catch (CouldNotSaveImageDataException $eContent) {
                    /** delete from database */
                    try {
                        $this->repository->deleteById($addedImageId);
                    } catch (RepositoryException $e) {
                        throw new CouldNotCreateException(sprintf(
                            '%s;%s;%s',
                            sprintf('Image was added to the database with id %s', $addedImageId()),
                            sprintf('Content was not saved with error %s', $eContent->getMessage()),
                            sprintf(
                                'Image with id %s must be deleted from database manualy with error %s',
                                $addedImageId(),
                                $e->getMessage()
                            )
                        ));
                    }

                    throw new CouldNotCreateException(
                        sprintf(
                            '%s;%s;%s',
                            sprintf('Image was added to the database with id %s', $addedImageId()),
                            sprintf('Content was not saved with error %s', $eContent->getMessage()),
                            'Image was removed from the database'
                        )
                    );
                }

                return $addedImageId;
            }
        } catch (RepositoryException $e) {
            throw new CouldNotCreateException($e->getMessage());
        }
    }

    /**
     * Delete image model
     * do 2 transactions:
     *   - deletes data from the database
     *   - removes content from the filesystem
     *
     * @throws CouldNotChangeActivityException
     * @throws CouldNotDeleteException
     * @throws InvalidArgumentException
     * @throws NoSuchImageException
     */
    public function delete(Delete $command): void
    {
        $id = ImageId::fromString($command->id);

        try {
            $model = $this->repository->getById($id);
            $path  = $model->getPath();
            // Deactivate
            $model->deactivate();
            try {
                // 1 transaction - delete from the database
                $this->repository->deleteById($id);
                // 2 transaction - remove content from the storage
                try {
                    $this->imageStorage->delete($model->getPath());
                } catch (CouldNotDeleteImageDataException $eDelete) {
                    try {
                        $content = $this->imageStorage->load($model->getPath());
                        $model->loadContent($content);
                        $model->activate();
                        try {
                            // deleted from database
                            // not deleted from storage
                            // loaded from storage
                            // activated
                            // restored in database
                            $this->repository->add($model);
                            throw new CouldNotDeleteException(sprintf(
                                '%s;%s;%s;%s;%s',
                                sprintf('Image with id %s was deleted from database', (string) $id),
                                sprintf(
                                    'Image was not removed from storage with error %s (file %s)',
                                    $eDelete->getMessage(),
                                    $path()
                                ),
                                sprintf('Image was loaded from storage (file %s)', $path()),
                                'Image was activated',
                                sprintf('Image was restored in the database with id %s', (string) $id),
                            ));
                        } catch (RepositoryException $eDatabaseRestore) {
                            // deleted from database
                            // not deleted from storage
                            // loaded from storage
                            // activated
                            // not restored in database
                            throw new CouldNotDeleteException(sprintf(
                                '%s;%s;%s;%s;%s',
                                sprintf('Image with id %s was deleted from database', (string) $id),
                                sprintf(
                                    'Image was not removed from storage with error %s (file %s)',
                                    $eDelete->getMessage(),
                                    $path()
                                ),
                                sprintf('Image was loaded from storage (file %s)', $path()),
                                'Image was activated',
                                sprintf(
                                    'Image with id %s was not restore in the database with error %s',
                                    $id(),
                                    $eDatabaseRestore->getMessage()
                                ),
                            ));
                        }
                    } catch (CouldNotLoadImageDataException $eLoad) {
                        throw new CouldNotDeleteException(
                            sprintf(
                                '%s;%s;%s',
                                sprintf('Image with id %s was deleted from database', (string) $id),
                                sprintf(
                                    'Image with path %s was not deleted from storage with error %s',
                                    $model->getPath(),
                                    $eDelete->getMessage()
                                ),
                                sprintf(
                                    'Image was not restore in the database because of storage load error %s',
                                    $eLoad->getMessage()
                                ),
                            )
                        );
                    } catch (CouldNotChangeActivityException $eActivity) {
                        throw new CouldNotDeleteException(
                            sprintf(
                                '%s;%s;%s',
                                sprintf('Image with id %s was deleted from database', (string) $id),
                                sprintf(
                                    'Image with path %s was not deleted from storage with error %s',
                                    $model->getPath(),
                                    $eDelete->getMessage()
                                ),
                                sprintf(
                                    'Image Was not restore in the database because of activation error %s',
                                    $eActivity->getMessage()
                                ),
                            )
                        );
                    }
                }
            } catch (RepositoryException $e) {
                throw new CouldNotDeleteException($e->getMessage());
            }
        } catch (RepositoryException $e) {
            throw new CouldNotDeleteException($e->getMessage());
        }
    }

    private function generateRandomString(int $length = 10): string
    {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
