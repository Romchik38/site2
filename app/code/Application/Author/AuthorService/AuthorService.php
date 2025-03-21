<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AuthorService;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Author\RepositoryInterface;
use Romchik38\Site2\Domain\Author\VO\AuthorId;

final class AuthorService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {   
    }

    /** 
     * @throws InvalidArgumentException
     * @throws NoSuchAuthorException
     */
    public function update(Update $command): void
    {
        $authorId = new AuthorId($command->id);
        $model = $this->repository->getById($authorId);

        // ... next
    }
}