<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleService;

use Romchik38\Site2\Application\Article\ArticleService\Exceptions\NoSuchArticleException;
use Romchik38\Site2\Application\Article\ArticleService\Exceptions\RepositoryException;
use Romchik38\Site2\Domain\Article\Article;
use Romchik38\Site2\Domain\Article\Entities\Audio;
use Romchik38\Site2\Domain\Article\Entities\Author;
use Romchik38\Site2\Domain\Article\Entities\Category;
use Romchik38\Site2\Domain\Article\Entities\Image;
use Romchik38\Site2\Domain\Article\VO\Identifier;
use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;

interface RepositoryInterface
{
    /** @throws RepositoryException */
    public function add(Article $model): void;

    /** @throws RepositoryException */
    public function clearViews(): void;

    /** @throws RepositoryException */
    public function createAudio(AudioId $id): Audio;

    /**
     * @param array<int,CategoryId> $categoryIds
     * @throws RepositoryException
     * @return array<int,Category>
     */
    public function createCategories(array $categoryIds): array;

    public function createImage(ImageId $imageId): Image;

    /** @throws RepositoryException */
    public function delete(Article $model): void;

    /** @throws RepositoryException */
    public function findAuthor(AuthorId $id): Author;

    /**
     * @throws NoSuchArticleException
     * @throws RepositoryException
     * */
    public function getById(Identifier $id): Article;

    /** @throws RepositoryException */
    public function save(Article $model): void;

    /** @throws RepositoryException */
    public function transactionEnd(): void;

    /** @throws RepositoryException */
    public function transactionStart(): void;

    /** @throws RepositoryException */
    public function updateViews(Article $model): void;
}
