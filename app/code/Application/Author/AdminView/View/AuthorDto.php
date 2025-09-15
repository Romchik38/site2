<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminView\View;

use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;

final readonly class AuthorDto
{
    /**
     * @param array<int,Translate> $translates
     * @param array<int,ArticleId> $articles
     * @param array<int,ImageId> $images
     * */
    public function __construct(
        public AuthorId $identifier,
        public Name $name,
        public bool $active,
        public array $translates,
        public array $articles,
        public array $images,
    ) {
    }
}
