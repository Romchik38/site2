<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\AdminList;

use InvalidArgumentException;
use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\CouldNotFilterException;
use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\Filter;
use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\FilterResult;
use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\SearchCriteria;
use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\VO\Limit;
use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\VO\Offset;
use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\VO\OrderByDirection;
use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\VO\OrderByField;
use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\VO\Page;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

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
    public function filter(Filter $command, string $language): FilterResult
    {
        $limit            = Limit::fromString($command->limit);
        $page             = Page::fromString($command->page);
        $orderByField     = new OrderByField($command->orderByField);
        $orderByDirection = new OrderByDirection($command->orderByDirection);
        $offset           = new Offset(($page() - 1) * $limit());
        $languageId       = new LanguageId($language);

        $searchCriteria = new SearchCriteria(
            $offset,
            $limit,
            $orderByField,
            $orderByDirection,
            $languageId
        );

        try {
            return new FilterResult(
                $searchCriteria,
                $page,
                $this->repository->filter($searchCriteria)
            );
        } catch (RepositoryException $e) {
            throw new CouldNotFilterException($e->getMessage());
        }
    }

    /** @throws RepositoryException */
    public function totalCount(): int
    {
        return $this->repository->totalCount();
    }
}
