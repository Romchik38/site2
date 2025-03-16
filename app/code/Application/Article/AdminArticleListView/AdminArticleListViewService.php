<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminArticleListView;

use Romchik38\Site2\Application\Article\AdminArticleListView\View\RepositoryInterface;
use Romchik38\Site2\Application\Article\AdminArticleListView\View\SearchCriteriaFactoryInterface;
use Romchik38\Site2\Application\Article\AdminArticleListView\View\ArticleDto;
use Romchik38\Site2\Application\Article\AdminArticleListView\VO\Limit;
use Romchik38\Site2\Application\Article\AdminArticleListView\VO\Offset;
use Romchik38\Site2\Application\Article\AdminArticleListView\VO\OrderByDirection;
use Romchik38\Site2\Application\Article\AdminArticleListView\VO\OrderByField;
use Romchik38\Site2\Application\Article\AdminArticleListView\VO\Page;

final class AdminArticleListViewService
{
    public function __construct(
        protected readonly RepositoryInterface $repository,
        private readonly SearchCriteriaFactoryInterface $searchCriteriaFactory
    ) {
    }

    /** @return array<int,ArticleDto> */
    public function list(Filter $command): array {
        $limit = Limit::fromString($command->limit);
        $page = Page::fromString($command->page);
        $orderByField = new OrderByField($command->orderByField);
        $orderByDirection = new OrderByDirection($command->orderByDirection);
        $offset = new Offset(($page() -1) * $limit());

        $searchCriteria = $this->searchCriteriaFactory->create(
            $offset(),
            $limit(),
            $orderByField(),
            $orderByDirection()
        );
        
        return $this->repository->list($searchCriteria);
    }
}