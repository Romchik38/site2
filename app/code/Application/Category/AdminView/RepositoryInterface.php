<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\AdminView;

use Romchik38\Site2\Application\Category\AdminView\View\CategoryDto;
use Romchik38\Site2\Domain\Category\VO\Identifier;

interface RepositoryInterface
{
    /**
     * @throws NoSuchCategoryException
     * @throws RepositoryException - On any database error.
     * */
    public function getById(Identifier $id): CategoryDto;
}
