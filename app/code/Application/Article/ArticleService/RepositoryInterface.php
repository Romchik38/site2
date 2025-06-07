<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleService;

use Romchik38\Site2\Domain\Article\Article;
use Romchik38\Site2\Domain\Article\Entities\Author;
use Romchik38\Site2\Domain\Article\Entities\Image;
use Romchik38\Site2\Domain\Article\VO\Identifier;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;

interface RepositoryInterface
{
    public function createImage(ImageId $imageId): Image;

    /** @throws RepositoryException */
    public function delete(Article $model): void;

    /**
     * @throws NoSuchArticleException
     * @throws RepositoryException
     * */
    public function getById(Identifier $id): Article;

    public function findAuthor(AuthorId $id): Author;

    /** @throws RepositoryException */
    public function save(Article $model): void;

    /** @throws RepositoryException */
    public function add(Article $model): Identifier;
}
