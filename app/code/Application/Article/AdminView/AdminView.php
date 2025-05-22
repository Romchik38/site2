<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminView;

use Romchik38\Site2\Application\Article\AdminView\Dto\ArticleDto;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;

final class AdminView
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotFindException
     * @throws NoSuchArticleException
     * */
    public function find(ArticleId $id): ArticleDto
    {
        try {
            return $this->repository->getById($id);
        } catch (RepositoryException $e) {
            throw new CouldNotFindException($e->getMessage());
        }
    }
}
