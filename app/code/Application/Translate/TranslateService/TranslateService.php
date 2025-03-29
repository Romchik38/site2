<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\TranslateService;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Language\VO\Identifier as VOIdentifier;
use Romchik38\Site2\Domain\Translate\RepositoryInterface;
use Romchik38\Site2\Domain\Translate\CouldDeleteException;
use Romchik38\Site2\Domain\Translate\NoSuchTranslateException;
use Romchik38\Site2\Domain\Translate\CouldNotSaveException;
use Romchik38\Site2\Domain\Translate\Entities\Phrase;
use Romchik38\Site2\Domain\Translate\VO\Identifier;
use Romchik38\Site2\Domain\Translate\RepositoryException;
use Romchik38\Site2\Domain\Translate\Translate;
use Romchik38\Site2\Domain\Translate\VO\Phrase as PhraseVO;

final class TranslateService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * @throws NoSuchTranslateException
     * @throws CouldNotSaveException
     */
    public function update(Update $command): Identifier
    {
        try {
            $translateId = new Identifier($command->id);
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

        $savedModel       = $this->repository->save($model);
        $savedTranslateId = $savedModel->getId();
        return $savedTranslateId;
    }

    /**
     * @throws InvalidArgumentException
     * @throws CouldDeleteException
     */
    public function delete(Delete $command)
    {   
        $translateId = new Identifier($command->id);

        $this->repository->deleteById($translateId);
    }

    public function create(Update $command): Identifier
    {
        try {
            $translateId = new Identifier($command->id);
            $model = $this->repository->getById($translateId);
        } catch (RepositoryException $e) {
            throw new CouldNotSaveException($e->getMessage());
        } catch (NoSuchTranslateException) {
            try {
                $phrases  = [];
                foreach ($command->phrases as $phrase) {
                    $phrases[] = new Phrase(
                        new VOIdentifier($phrase->language),
                        new PhraseVO($phrase->phrase)
                    );
                }
                $model = new Translate($translateId, $phrases);
                $savedModel = $this->repository->add($model);
                return $savedModel->getId();
            } catch (RepositoryException $e) {
                throw new CouldNotSaveException($e->getMessage());
            }
        }

        throw new CouldNotSaveException('Error while creating new translate');
    }
}
