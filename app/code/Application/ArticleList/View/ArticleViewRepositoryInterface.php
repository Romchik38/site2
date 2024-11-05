<?php

namespace Romchik38\Site2\Application\ArticleList\View;

use Romchik38\Site2\Domain\Article\VO\ArticleId;

interface ArticleViewRepositoryInterface
{
    public function getByIdAndLanguage(ArticleId $id, string $language): ArticleDTO;
}
