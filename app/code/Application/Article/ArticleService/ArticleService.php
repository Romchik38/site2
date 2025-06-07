<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleService;

use Romchik38\Site2\Application\Article\ArticleService\Commands\Update;
use Romchik38\Site2\Application\Category\CategoryService\Exceptions\{
    CouldNotCreateException,
    CouldNotDeleteException,
    CouldNotUpdateException,
    NoSuchArticleException,
    RepositoryException
};
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;

final class ArticleService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotUpdateException
     * @throws InvalidArgumentException
     * @throws NoSuchArticleException
     */
    public function update(Update $command): void
    {
        $id = new ArticleId($command->id);

        try {
            $model = $this->repository->getById($id);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        }

        $model;
    }
}
