<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AuthorService;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Author\Entities\Translate;
use Romchik38\Site2\Domain\Author\RepositoryInterface;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Description;
use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Language\VO\Identifier;

final class AuthorService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {   
    }

    /** 
     * @throws DuplicateIdException
     * @throws InvalidArgumentException
     * @throws NoSuchAuthorException
     * @throws CouldNotSaveException
     * @throws CouldNotChangeActivityException
     */
    public function update(Update $command): void
    {
        $authorId = new AuthorId($command->id);
        $name = new Name($command->name);

        $model = $this->repository->getById($authorId);

        // Name
        $model->reName($name);
        
        // translates
        foreach ($command->translates as $translate)
        {
            $model->addTranslate(new Translate(
                new Identifier($translate->language),
                new Description($translate->description)
            ));
        }

        // Activity
        if ($command->changeActivity === Update::CHANGE_ACTIVITY_YES_FIELD) {
            if($model->isActive()) {
                $model->deactivate();
            } else {
                $model->activate();
            }
        };

        $this->repository->save($model);
    }
}