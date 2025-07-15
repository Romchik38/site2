<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\PageService;

use Romchik38\Site2\Application\Page\PageService\Exceptions\NoSuchPageException;
use Romchik38\Site2\Application\Page\PageService\Exceptions\RepositoryException;
use Romchik38\Site2\Domain\Page\Page;
use Romchik38\Site2\Domain\Page\VO\Id;

interface RepositoryInterface
{
    /** @throws RepositoryException */
    public function add(Page $model): Id;

    /** @throws RepositoryException */
    public function delete(Page $model): void;

    /**
     * @throws NoSuchPageException
     * @throws RepositoryException
     * */
    public function getById(Id $id): Page;

    /** @throws RepositoryException */
    public function save(Page $model): void;

    /** @throws RepositoryException */
    public function transactionCancel(): void;

    /** @throws RepositoryException */
    public function transactionEnd(): void;

    /** @throws RepositoryException */
    public function transactionStart(): void;
}
