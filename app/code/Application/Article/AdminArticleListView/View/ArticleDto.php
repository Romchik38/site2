<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminArticleListView\View;

final class ArticleDto
{
    public function __construct(
        public readonly string $identifier,
        public readonly string $active,
        public readonly string $authorId,
        public readonly string $imgId,
        public readonly string $audioId
    ) {  
    }
}
