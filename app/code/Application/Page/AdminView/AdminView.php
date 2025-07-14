<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\AdminView;

use InvalidArgumentException;
use Romchik38\Site2\Application\Page\AdminView\View\PageDto;
use Romchik38\Site2\Domain\Page\VO\Id;

final class AdminView
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotFindException
     * @throws InvalidArgumentException
     * @throws NoSuchPageException
     * */
    public function find(string $id): PageDto
    {
        $pageId = Id::fromString($id);

        try {
            return $this->repository->getById($pageId);
        } catch (RepositoryException $e) {
            throw new CouldNotFindException($e->getMessage());
        }
    }
}
