<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Author;

use Romchik38\Site2\Domain\Author\VO\AuthorId;

interface RepositoryInterface
{
    /** 
     * @throws DuplicateIdException
     * @throws NoSuchAuthorException
     * 
     * @todo implement catch block RepositoryException
     * @throws RepositoryException
     * */
    public function getById(AuthorId $id): Author;

    /** @throws CouldNotSaveException */
    public function save(Author $model): Author;
}
