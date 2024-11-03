<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\Services;

use Romchik38\Site2\Domain\Article\Services\CO\Pagination;
use Romchik38\Site2\Domain\Article\VO\ArticleId;

final class ArticleListService
{
    /** Any sorting 
     * @return ArticleId[]
    */
    public function listArticles(Pagination $pagination): array
    {

        return [];
    }
}
