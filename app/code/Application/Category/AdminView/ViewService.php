<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\AdminView;

use Romchik38\Site2\Application\Category\AdminView\View\CategoryDto;
use Romchik38\Site2\Domain\Category\VO\Identifier;

final class ViewService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotFindException
     * @throws NoSuchCategoryException
     * */
    public function find(Identifier $id): CategoryDto
    {
        try {
            return $this->repository->getById($id);
        } catch (RepositoryException $e) {
            throw new CouldNotFindException($e->getMessage());
        }
    }
}
