<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminAuthorList;

use Romchik38\Site2\Application\Author\AdminAuthorList\VO\Limit;
use Romchik38\Site2\Application\Author\AdminAuthorList\VO\Offset;
use Romchik38\Site2\Application\Author\AdminAuthorList\VO\OrderByDirection;
use Romchik38\Site2\Application\Author\AdminAuthorList\VO\OrderByField;
use Romchik38\Site2\Application\Author\AdminAuthorList\VO\Page;

final class AdminAuthorList
{
    public function __construct(
        protected readonly RepositoryInterface $repository,
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