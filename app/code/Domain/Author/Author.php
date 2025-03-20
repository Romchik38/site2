<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Author;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Image\VO\Id;

final class Author
{
    private AuthorId $identifier;
    private Name $name;
    private array $articles;
    private array $translates;
    private array $images;

    /** 
     * @param array<int,string> $articles
     * @param array<int,string> $images
     * @throws InvalidArgumentException
     * */
    public function __construct(
        string $identifier,
        string $name,
        private bool $active,
        array $translates = [],
        array $articles = [],
        array $images = []
    ) {
        $this->identifier = new AuthorId($identifier);
        $this->name = new Name($name);
        // article
        $this->articles = [];
        foreach($articles as $article) {
            $this->articles[] = new ArticleId($article);
        }
        // images
        $this->images = [];
        foreach($images as $image) {
            $this->images[] = new Id($image);
        }
        
    }
}
