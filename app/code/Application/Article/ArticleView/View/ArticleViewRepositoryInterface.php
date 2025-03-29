<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleView\View;

use Romchik38\Site2\Application\Article\ArticleView\Find;
use Romchik38\Site2\Application\Article\ArticleView\NoSuchArticleException;
use Romchik38\Site2\Application\Article\ArticleView\RepositoryException;

interface ArticleViewRepositoryInterface
{
    /**
     * @throws NoSuchArticleException
     * @throws RepositoryException - On any database/structure error.
     */
    public function getByIdAndLanguage(Find $command): ArticleViewDTO;

    /**
     * all active article ids
     *
     * @return string[]
     */
    public function listIds(): array;

    /** @return array<int,ArticleIdNameDTO> */
    public function listIdName(string $language): array;
}
