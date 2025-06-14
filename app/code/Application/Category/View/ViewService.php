<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\View;

use InvalidArgumentException;
use Romchik38\Site2\Application\Category\View\Commands\Filter\Filter;
use Romchik38\Site2\Application\Category\View\Commands\Filter\FilterResult;
use Romchik38\Site2\Application\Category\View\Commands\Filter\VO\Limit;
use Romchik38\Site2\Application\Category\View\Commands\Filter\VO\Offset;
use Romchik38\Site2\Application\Category\View\Commands\Filter\VO\OrderByDirection;
use Romchik38\Site2\Application\Category\View\Commands\Filter\VO\OrderByField;
use Romchik38\Site2\Application\Category\View\Commands\Filter\VO\Page;
use Romchik38\Site2\Application\Category\View\Commands\Filter\SearchCriteria;
use Romchik38\Site2\Application\Category\View\Exceptions\CouldNotCountException;
use Romchik38\Site2\Application\Category\View\Exceptions\CouldNotFilterException;
use Romchik38\Site2\Application\Category\View\Exceptions\RepositoryException;

final class ViewService
{
    public function __construct(
        private readonly RepositoryInterface $articleListViewRepository
    ) {
    }

    /**
     * @throws CouldNotFilterException
     * @throws InvalidArgumentException
     * */
    public function list(Filter $command, string $language): FilterResult
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
            $orderByDirection,
            $language
        );

        try {
            $list = $this->articleListViewRepository->list($searchCriteria);
        } catch (RepositoryException $e) {
            throw new CouldNotFilterException($e->getMessage());
        }

        return new FilterResult($searchCriteria, $page, $list);
    }

    /**
     * count of all active article
     *
     * @throws CouldNotCountException
     * */
    public function listTotal(): int
    {
        try {
            return $this->articleListViewRepository->totalCount();
        } catch (RepositoryException $e) {
            throw new CouldNotCountException($e->getMessage());
        }
    }
}
