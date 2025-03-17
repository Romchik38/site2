<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminArticleListView\View;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Img\VO\Path;

final class ArticleDto
{
    public readonly ArticleId $identifier;
    public readonly Path|null $imgPath;
    public readonly Name $authorName;

    public function __construct(
        string $identifier,
        public readonly bool $active,
        public readonly bool|null $imgActive,
        string|null $imgPath,
        public readonly bool|null $audioActive,
        string $authorName
    ) {
        // Id
        $this->identifier = new ArticleId($identifier);

        // Img Path
        if ($imgPath === null) {
            $this->imgPath = $imgPath;
        } else {
            $this->imgPath = new Path($imgPath);
        }

        // Author name
        $this->authorName = new Name($authorName);
    }
}
