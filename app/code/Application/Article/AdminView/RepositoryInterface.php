<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminView;

use Romchik38\Site2\Application\Article\AdminView\Dto\ArticleDto;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;

interface RepositoryInterface
{
    /**
     * @throws NoSuchArticleException
     * @throws RepositoryException
     * */
    public function getById(ArticleId $id): ArticleDto;
}
