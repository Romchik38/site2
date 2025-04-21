<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\ListView;

use InvalidArgumentException;
use Romchik38\Site2\Application\Translate\ListView\VO\Limit;
use Romchik38\Site2\Application\Translate\ListView\VO\Offset;
use Romchik38\Site2\Application\Translate\ListView\VO\OrderByDirection;
use Romchik38\Site2\Application\Translate\ListView\VO\OrderByField;
use Romchik38\Site2\Application\Translate\ListView\VO\Page;

final class ListViewService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
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

        /** @todo CouldNotFilterException */
        return new FilterResult(
            $searchCriteria,
            $page,
            $this->repository->list($searchCriteria)
        );
    }

    public function totalCount(): int
    {
        /** @todo catch repo exc */
        return $this->repository->totalCount();
    }
}
