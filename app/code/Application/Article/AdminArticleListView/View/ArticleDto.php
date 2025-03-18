<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminArticleListView\View;

use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Id;

final class ArticleDto
{
    public readonly ArticleId $identifier;
    public readonly Id|null $imgIdentifier;
    public readonly Name $authorName;

    public function __construct(
        string $identifier,
        public readonly bool $active,
        public readonly bool|null $imgActive,
        string|null $imgIdentifier,
        public readonly bool|null $audioActive,
        string $authorName
    ) {
        // Id
        $this->identifier = new ArticleId($identifier);

        // Img imgIdentifier
        if ($imgIdentifier === null) {
            $this->imgIdentifier = $imgIdentifier;
        } else {
            $this->imgIdentifier = new Id($imgIdentifier);
        }

        // Author name
        $this->authorName = new Name($authorName);
    }

    public function imageIdentifierAsString(): string
    {
        return ($this->imgIdentifier)();
    }

    public function authorNameAsString(): string
    {
        return ($this->authorName)();
    }

    public function identifierAsString(): string
    {
        return ($this->identifier)();
    }
}
