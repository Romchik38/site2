<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Author;

use Romchik38\Site2\Domain\Author\VO\AuthorId;

interface RepositoryInterface
{
    /**
     * @throws NoSuchAuthorException
     * @throws RepositoryException
     * */
    public function getById(AuthorId $id): Author;

    /** @throws CouldDeleteException */
    public function delete(Author $model): void;

    /** @throws CouldNotSaveException */
    public function save(Author $model): Author;
}
