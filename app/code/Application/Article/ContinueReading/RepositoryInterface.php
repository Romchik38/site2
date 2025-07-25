<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ContinueReading;

use Romchik38\Site2\Application\Article\ContinueReading\Commands\Find\SearchCriteria;
use Romchik38\Site2\Application\Article\ContinueReading\Commands\List\SearchCriteria as ListSearchCriteria;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\NoSuchArticleException;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\ContinueReading\View\ArticleDto;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException
     * */
    public function checkById(ArticleId $id): bool;

    /**
     * @throws NoSuchArticleException
     * @throws RepositoryException
     * */
    public function find(SearchCriteria $id): ArticleDto;

    /**
     * @throws RepositoryException
     * @return array<int,ArticleDto>
     * */
    public function list(ListSearchCriteria $searchCriteria): array;
}
