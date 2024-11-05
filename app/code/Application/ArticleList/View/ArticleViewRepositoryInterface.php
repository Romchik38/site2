<?php

namespace Romchik38\Site2\Application\ArticleList\View;

interface ArticleViewRepositoryInterface {
    public function getByIdAndLanguage(ArticleId $id, string $language): ArticleDTO;
    
}