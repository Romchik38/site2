<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AuthorService;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Author\RepositoryInterface;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name;

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
     */
    public function update(Update $command): void
    {
        $authorId = new AuthorId($command->id);
        $name = new Name($command->name);

        $model = $this->repository->getById($authorId);

        $model->reName($name);
        // ... next
        $a = 1;
    }
}