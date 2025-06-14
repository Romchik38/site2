<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\View;

use InvalidArgumentException;
use Romchik38\Site2\Application\Category\View\Commands\Filter\Filter;
use Romchik38\Site2\Application\Category\View\Commands\Filter\FilterResult;
use Romchik38\Site2\Application\Category\View\Commands\Filter\SearchCriteria;
use Romchik38\Site2\Application\Category\View\Commands\Filter\VO\Limit;
use Romchik38\Site2\Application\Category\View\Commands\Filter\VO\Offset;
use Romchik38\Site2\Application\Category\View\Commands\Filter\VO\OrderByDirection;
use Romchik38\Site2\Application\Category\View\Commands\Filter\VO\OrderByField;
use Romchik38\Site2\Application\Category\View\Commands\Filter\VO\Page;
use Romchik38\Site2\Application\Category\View\Exceptions\CouldNotFindException;
use Romchik38\Site2\Application\Category\View\Exceptions\NoSuchCategoryException;
use Romchik38\Site2\Application\Category\View\Exceptions\RepositoryException;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class ViewService
{
    public function __construct(
        private readonly RepositoryInterface $articleListViewRepository
    ) {
    }

    /**
     * @throws CouldNotFindException
     * @throws InvalidArgumentException
     * @throws NoSuchCategoryException
     * */
    public function find(Filter $command, string $languageId, string $categoryId): FilterResult
    {
        $limit            = Limit::fromString($command->limit);
        $page             = Page::fromString($command->page);
        $orderByField     = new OrderByField($command->orderByField);
        $orderByDirection = new OrderByDirection($command->orderByDirection);
        $offset           = new Offset(($page() - 1) * $limit());

        $languageId = new LanguageId($languageId);
        $categoryId = new CategoryId($categoryId);

        $searchCriteria = new SearchCriteria(
            $offset,
            $limit,
            $orderByField,
            $orderByDirection,
            $languageId,
            $categoryId
        );

        try {
            $category = $this->articleListViewRepository->find($searchCriteria);
        } catch (RepositoryException $e) {
            throw new CouldNotFindException($e->getMessage());
        }

        return new FilterResult($searchCriteria, $page, $category);
    }
}
