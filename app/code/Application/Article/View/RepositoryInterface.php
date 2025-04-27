<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\View;

use Romchik38\Site2\Application\Article\View\Find;
use Romchik38\Site2\Application\Article\View\NoSuchArticleException;
use Romchik38\Site2\Application\Article\View\RepositoryException;
use Romchik38\Site2\Application\Article\View\View\ArticleIdNameDTO;
use Romchik38\Site2\Application\Article\View\View\ArticleViewDTO;

interface RepositoryInterface
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
