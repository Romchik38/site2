<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\AdminList;

use InvalidArgumentException;
use Romchik38\Site2\Application\Category\AdminList\VO\Limit;
use Romchik38\Site2\Application\Category\AdminList\VO\Offset;
use Romchik38\Site2\Application\Category\AdminList\VO\OrderByDirection;
use Romchik38\Site2\Application\Category\AdminList\VO\OrderByField;
use Romchik38\Site2\Application\Category\AdminList\VO\Page;
use Romchik38\Site2\Application\Category\AdminList\View\CategoryDto;

final class AdminList
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotFilterException
     * @throws InvalidArgumentException
     * */
    public function list(Filter $command): FilterResult
    {
        $limit            = Limit::fromString($command->limit);
        $page             = Page::fromString($command->page);
        $orderByField     = new OrderByField($command->orderByField);
        $orderByDirection = new OrderByDirection($command->orderByDirection);
        $offset           = new Offset(($page() - 1) * $limit());

        $searchCriteria = new SearchCriteria(
            $offset,
            $limit,
            $orderByField,
            $orderByDirection
        );

        try {
            return new FilterResult(
                $searchCriteria,
                $page,
                $this->repository->list($searchCriteria)
            );
        } catch (RepositoryException $e) {
            throw new CouldNotFilterException($e->getMessage());
        }
    }

    /** @throws CouldNotCountException */
    public function totalCount(): int
    {
        try {
            return $this->repository->totalCount();
        } catch (RepositoryException $e) {
            throw new CouldNotCountException($e->getMessage());
        }
    }

    /**
     * @throws CouldNotListAllException
     * @return array<int,CategoryDto>
     */
    public function listAll(): array
    {
        try {
            return $this->repository->listAll();
        } catch (RepositoryException $e) {
            throw new CouldNotListAllException($e->getMessage());
        }
    }
}
