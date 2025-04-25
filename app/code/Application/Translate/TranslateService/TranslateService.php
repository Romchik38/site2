<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\TranslateService;

use InvalidArgumentException;
use Romchik38\Site2\Application\Translate\TranslateService\Exceptions\CouldNotDeleteException;
use Romchik38\Site2\Application\Translate\TranslateService\Exceptions\CouldNotSaveException;
use Romchik38\Site2\Application\Translate\TranslateService\Exceptions\NoSuchTranslateException;
use Romchik38\Site2\Application\Translate\TranslateService\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Translate\TranslateService\RepositoryInterface;
use Romchik38\Site2\Domain\Language\VO\Identifier as VOIdentifier;
use Romchik38\Site2\Domain\Translate\Entities\Phrase;
use Romchik38\Site2\Domain\Translate\Translate;
use Romchik38\Site2\Domain\Translate\VO\Identifier;
use Romchik38\Site2\Domain\Translate\VO\Phrase as PhraseVO;

use function sprintf;

final class TranslateService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotSaveException
     * @throws InvalidArgumentException
     * @throws NoSuchTranslateException
     */
    public function update(Update $command): void
    {
        $translateId = new Identifier($command->id);

        try {
            $model = $this->repository->getById($translateId);
        } catch (RepositoryException $e) {
            throw new CouldNotSaveException($e->getMessage());
        }

        // translates
        foreach ($command->phrases as $phrase) {
            $model->addPhrase(new Phrase(
                new VOIdentifier($phrase->language),
                new PhraseVO($phrase->phrase)
            ));
        }

        try {
            $this->repository->save($model);
        } catch (RepositoryException $e) {
            throw new CouldNotSaveException($e->getMessage());
        }
    }

    /**
     * @throws InvalidArgumentException
     * @throws CouldNotDeleteException
     */
    public function delete(Delete $command): void
    {
        $translateId = new Identifier($command->id);

        try {
            $this->repository->deleteById($translateId);
        } catch (RepositoryException $e) {
            throw new CouldNotDeleteException($e->getMessage());
        }
    }

    /**
     * @throws CouldNotSaveException
     * @throws InvalidArgumentException
     * */
    public function create(Update $command): void
    {
        $translateId = new Identifier($command->id);

        try {
            $found = $this->repository->getById($translateId);
        } catch (RepositoryException $e) {
            throw new CouldNotSaveException($e->getMessage());
        } catch (NoSuchTranslateException) {
            $phrases = [];
            foreach ($command->phrases as $phrase) {
                $phrases[] = new Phrase(
                    new VOIdentifier($phrase->language),
                    new PhraseVO($phrase->phrase)
                );
            }
            $model = new Translate($translateId, $phrases);
            try {
                $this->repository->add($model);
                return;
            } catch (RepositoryException $e) {
                throw new CouldNotSaveException($e->getMessage());
            }
        }

        throw new InvalidArgumentException(sprintf(
            'Translate with id %s already exist',
            $translateId
        ));
    }
}
