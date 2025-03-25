<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminView;

use Romchik38\Site2\Application\Author\AdminView\View\AuthorDto;
use Romchik38\Site2\Domain\Author\NoSuchAuthorException;
use Romchik38\Site2\Domain\Author\VO\AuthorId;

final class AdminViewService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws NoSuchAuthorException
     * @throws DuplicateIdException
     * */
    public function find(AuthorId $id): AuthorDto
    {
        return $this->repository->getById($id);
    }
}
