<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AuthorService;

use Romchik38\Site2\Application\Author\AuthorService\Exceptions\NoSuchAuthorException;
use Romchik38\Site2\Application\Author\AuthorService\Exceptions\RepositoryException;
use Romchik38\Site2\Domain\Author\Author;
use Romchik38\Site2\Domain\Author\VO\AuthorId;

interface RepositoryInterface
{
    /** @throws RepositoryException */
    public function add(Author $model): AuthorId;

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
