<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Author;

use Romchik38\Site2\Domain\Author\VO\AuthorId;

interface RepositoryInterface
{
    /** 
     * @throws DuplicateIdException
     * @throws NoSuchAuthorException 
     * */
    public function getById(AuthorId $id): Author;

    public function save(Author $model): Author;
}
