<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\Article\View;

use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Name;

final class ArticleDto
{
    public function __construct(
        public readonly ArticleId $id,
        public readonly Name $name,
        public readonly AuthorDto $author,
        public readonly ImageDto $image
    ) {
    }
}
