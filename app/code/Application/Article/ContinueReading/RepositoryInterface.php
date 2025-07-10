<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ContinueReading;

use Romchik38\Site2\Application\Article\ContinueReading\Commands\Find\SearchCriteria;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\NoSuchArticleException;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\ContinueReading\View\ArticleDto;

interface RepositoryInterface
{
    /**
     * @throws NoSuchArticleException
     * @throws RepositoryException
     * */
    public function find(SearchCriteria $id): ArticleDto;
}
