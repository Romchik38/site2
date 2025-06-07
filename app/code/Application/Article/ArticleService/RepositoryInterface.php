<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleService;

use Romchik38\Site2\Domain\Article\Article;
use Romchik38\Site2\Domain\Article\VO\Identifier;

interface RepositoryInterface
{
    /**
     * @throws NoSuchArticleException
     * @throws RepositoryException
     * */
    public function getById(Identifier $id): Article;

    /** @throws RepositoryException */
    public function delete(Article $model): void;

    /** @throws RepositoryException */
    public function save(Article $model): void;

    /** @throws RepositoryException */
    public function add(Article $model): Identifier;
}
