<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\SimilarArticles;

use Romchik38\Site2\Application\Article\SimilarArticles\Commands\ListSimilar\SearchCriteria;
use Romchik38\Site2\Application\Article\SimilarArticles\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\SimilarArticles\View\ArticleDto;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException
     * @return array<int,ArticleDto>
     * */
    public function list(SearchCriteria $searchCriteria): array;
}
