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
     */
    public function update(Update $command): void
    {
        $authorId = new AuthorId($command->id);
        $name = new Name($command->name);

        $model = $this->repository->getById($authorId);

        $model->reName($name);
        
        // translates
        foreach ($command->translates as $translate)
        {
            $model->addTranslate(new Translate(
                new Identifier($translate->language),
                new Description($translate->description)
            ));
        }

        $this->repository->save($model);
    }
}