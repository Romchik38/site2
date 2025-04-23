<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\CategoryService;

use Romchik38\Site2\Application\Category\CategoryService\Exceptions\NoSuchCategoryException;
use Romchik38\Site2\Application\Category\CategoryService\Exceptions\RepositoryException;
use Romchik38\Site2\Domain\Category\Category;
use Romchik38\Site2\Domain\Category\VO\Identifier;

interface RepositoryInterface
{
    /**
     * @throws NoSuchCategoryException
     * @throws RepositoryException
     * */
    public function getById(Identifier $id): Category;

    /** @throws RepositoryException */
    public function delete(Category $model): void;

    /** @throws RepositoryException */
    public function save(Category $model): void;

    /** @throws RepositoryException */
    public function add(Category $model): Identifier;
}
