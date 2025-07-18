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

    /** @throws RepositoryException */
    public function delete(Author $model): void;

    /** @throws RepositoryException */
    public function save(Author $model): Author;
}
