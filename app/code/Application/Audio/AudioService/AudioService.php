<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AudioService;

use InvalidArgumentException;
use Romchik38\Site2\Application\Language\List\Exceptions\RepositoryException as LanguageRepositoryException;
use Romchik38\Site2\Application\Language\List\ListViewService;
use Romchik38\Site2\Domain\Audio\Audio;
use Romchik38\Site2\Domain\Audio\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Audio\Entities\Translate;
use Romchik38\Site2\Domain\Audio\VO\Description;
use Romchik38\Site2\Domain\Audio\VO\Id;
use Romchik38\Site2\Domain\Audio\VO\Name;
use Romchik38\Site2\Domain\Audio\VO\Path;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function count;
use function in_array;
use function random_int;
use function sprintf;
use function strlen;

final class AudioService
{
    public const CONTENT_NAME_LENGTH = 20;

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

        $addedId = $addedModel->getId();
        if ($addedId === null) {
            throw new CouldNotCreateException(sprintf(
                'Model id for audio with name %s not updated',
                $name()
            ));
        }
        return $addedId;
    }

    /**
     * @throws CouldNotChangeActivityException
     * @throws CouldNotDeleteAudioException
     * @throws InvalidArgumentException
     * @throws NoSuchAudioException
     */
    public function delete(Delete $command): void
    {
        $id = Id::fromString($command->id);

        try {
            $model = $this->repository->getById($id);
        } catch (RepositoryException $e) {
            throw new CouldNotDeleteAudioException($e->getMessage());
        }

        $model->deactivate();

        $translates = $model->getTranslates();
        if (count($translates) > 0) {
            throw new CouldNotDeleteAudioException(sprintf(
                'Faild to delete audio with id %s, it has translates. Delete them first',
                (string) $id
            ));
        }

        try {
            $this->repository->delete($model);
        } catch (RepositoryException $e) {
            throw new CouldNotDeleteAudioException($e->getMessage());
        }
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

    /**
     * @throws CouldNotUpdateTranslateException
     * @throws InvalidArgumentException
     * @throws NoSuchAudioException
     * @throws NoSuchTranslateException
     */
    public function updateTranslate(UpdateTranslate $command): void
    {
        $audioId  = Id::fromString($command->id);
        $language = new LanguageId($command->language);

        try {
            $model = $this->repository->getById($audioId);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateTranslateException($e->getMessage());
        }

        $translate = $model->getTranslate($language());
        if ($translate === null) {
            throw new NoSuchTranslateException(sprintf(
                'Audio translate with language %s not exist',
                $language()
            ));
        }

        $translate->changeDescription(new Description($command->description));

        $model->addTranslate($translate);

        try {
            $this->repository->save($model);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateTranslateException($e->getMessage());
        }
    }

    /**
     * @throws CouldNotCreateTranslateException
     * @throws InvalidArgumentException
     */
    public function createTranslate(CreateTranslate $command): void
    {
        $audioId     = Id::fromString($command->id);
        $language    = new LanguageId($command->language);
        $description = new Description($command->description);

        try {
            $model = $this->repository->getById($audioId);
        } catch (RepositoryException $e) {
            throw new CouldNotCreateTranslateException($e->getMessage());
        } catch (NoSuchAudioException $e) {
            throw new CouldNotCreateTranslateException($e->getMessage());
        }

        $translate = $model->getTranslate($language());
        if ($translate !== null) {
            throw new CouldNotCreateTranslateException(sprintf(
                'Audio with id %s already has translate in %s language',
                $audioId(),
                $language()
            ));
        }

        $folder = $command->folder;
        if (! in_array($folder, CreateTranslate::ALLOWED_FOLDERS)) {
            throw new CouldNotCreateTranslateException(sprintf(
                'audio folder %s is not allowed',
                $folder
            ));
        }

        try {
            $content = $this->audioStorage->createContent($command->file);
        } catch (CouldNotCreateContentException $e) {
            throw new CouldNotCreateTranslateException($e->getMessage());
        }

        $path = sprintf(
            '%s/%s.%s',
            $folder,
            $this->generateRandomString($this::CONTENT_NAME_LENGTH),
            ($content->getType())()
        );

        $translate = new Translate(
            $language,
            $description,
            new Path($path)
        );

        // TRANSACTION START
        // Transaction 1: save content
        try {
            $this->audioStorage->save($content, $translate->getPath());
        } catch (CouldNotSaveAudioDataException $e) {
            throw new CouldNotCreateTranslateException($e->getMessage());
        }
        // Transaction 2: save model
        try {
            $model->addTranslate($translate);
            $this->repository->save($model);
        } catch (InvalidArgumentException $e) {
            // Rollback Transaction 1
            $this->removeContent($translate->getPath(), $e->getMessage(), (string) $audioId, $language());
        } catch (RepositoryException $e) {
            // Rollback Transaction 1
            $this->removeContent($translate->getPath(), $e->getMessage(), (string) $audioId, $language());
        }
    }

    /**
     * @throws CouldNotChangeActivityException
     * @throws CouldNotDeleteTranslateException
     * @throws InvalidArgumentException
     * @throws NoSuchAudioException
     * @throws NoSuchTranslateException
     */
    public function deleteTranslate(DeleteTranslate $command): void
    {
        $audioId  = Id::fromString($command->id);
        $language = new LanguageId($command->language);

        try {
            $model = $this->repository->getById($audioId);
        } catch (RepositoryException $e) {
            throw new CouldNotDeleteTranslateException($e->getMessage());
        }

        $translate = $model->getTranslate($language());
        if ($translate === null) {
            throw new NoSuchTranslateException(sprintf(
                'Audio translate with language %s not exist',
                $language()
            ));
        }

        try {
            $content = $this->audioStorage->load($translate->getPath());
        } catch (CouldNotLoadAudioDataException $e) {
            throw new CouldNotDeleteTranslateException($e->getMessage());
        }

        $translate->loadContent($content);

        $model->deactivate();
        $model->deleteTranslate($language());

        // TRANSACTION 1: remove content
        try {
            $this->audioStorage->deleteByPath($translate->getPath());
        } catch (CouldNotDeleteAudioDataException $e) {
            throw new CouldNotDeleteTranslateException($e->getMessage());
        }
        // TRANSACTION 2: save to database
        try {
            $this->repository->save($model);
        } catch (RepositoryException $e) {
            // restore content
            try {
                $this->audioStorage->save($content, $translate->getPath());
            } catch (CouldNotSaveAudioDataException $e2) {
                throw new CouldNotDeleteTranslateException(sprintf(
                    '%s;%s;%s;%s',
                    sprintf(
                        'Error while deleting audio translate id %s language %s',
                        (string) $audioId,
                        $language()
                    ),
                    'Content was removed',
                    sprintf('Translate was not removed from database with error %s', $e->getMessage()),
                    sprintf('Content was not restored in the storage with error %s', $e2->getMessage())
                ));
            }
            throw new CouldNotDeleteTranslateException(sprintf(
                '%s;%s;%s;%s',
                sprintf(
                    'Error while deleting audio translate id %s language %s',
                    (string) $audioId,
                    $language()
                ),
                'Content was removed',
                sprintf('Translate was not removed from database with error %s', $e->getMessage()),
                'Content was restored successfully'
            ));
        }
    }

    /**
     * Create translate part
     *
     * @throws CouldNotCreateTranslateException */
    private function removeContent(
        Path $path,
        string $errorMessage,
        string $id,
        string $language
    ): void {
        try {
            // Case 1: success rollback
            $this->audioStorage->deleteByPath($path);
            $message = sprintf(
                '%s;%s;%s;%s',
                sprintf('Audio id %s translate for language %s', $id, $language),
                sprintf('Content was stored successfully'),
                sprintf('Was not saved in database with error %s', $errorMessage),
                'Content was removed successfully'
            );
        } catch (CouldNotDeleteAudioDataException $eAudioData) {
            // Case 2: failed rollback
            $message = sprintf(
                '%s;%s;%s;%s',
                sprintf('Audio id %s translate for language %s', $id, $language),
                sprintf('Content was stored successfully'),
                sprintf('Was not saved in database with error %s', $errorMessage),
                sprintf('Content was not removed with error %s', $eAudioData->getMessage())
            );
        }

        throw new CouldNotCreateTranslateException($message);
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
