<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminList;

use InvalidArgumentException;
use Romchik38\Site2\Application\Author\AdminList\VO\Limit;
use Romchik38\Site2\Application\Author\AdminList\VO\Offset;
use Romchik38\Site2\Application\Author\AdminList\VO\OrderByDirection;
use Romchik38\Site2\Application\Author\AdminList\VO\OrderByField;
use Romchik38\Site2\Application\Author\AdminList\VO\Page;

final class AdminAuthorList
{
    public function __construct(
        private readonly RepositoryInterface $repository,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * @throws RepositoryException - On database structure error.
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

        return new FilterResult(
            $searchCriteria,
            $page,
            $this->repository->list($searchCriteria)
        );
    }

    public function totalCount(): int
    {
        return $this->repository->totalCount();
    }
}
