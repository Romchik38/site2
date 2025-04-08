<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image;

use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Image\Entities\Author;
use Romchik38\Site2\Domain\Image\NoSuchAuthorException;
use Romchik38\Site2\Domain\Image\VO\Id;

interface ImageRepositoryInterface
{
    /**
     * @throws NoSuchImageException
     * @throws RepositoryException
     * */
    public function getById(Id $id): Image;

    /**
     * @throws NoSuchAuthorException
     * @throws RepositoryException
     */
    public function findAuthor(AuthorId $id): Author;

    /** @throws RepositoryException */
    public function save(Image $model): void;

    /** @throws RepositoryException */
    public function add(Image $model): Image;

    /** @throws RepositoryException */
    public function deleteById(Id $id): void;
}
