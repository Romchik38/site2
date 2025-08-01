<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\Article\View;

use DateTime;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Name;
use Romchik38\Site2\Domain\Article\VO\ShortDescription;

final class ArticleDto
{
    public function __construct(
        public readonly ArticleId $id,
        public readonly DateTime $createdAt,
        public readonly Name $name,
        public readonly ShortDescription $shortDescription,
        public readonly AuthorDto $author,
        public readonly ImageDto $image,
    ) {
    }
}
