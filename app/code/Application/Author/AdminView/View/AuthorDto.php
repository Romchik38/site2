<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminView\View;

use Romchik38\Site2\Domain\Author\Entities\Translate;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;

final class AuthorDto
{
    public readonly AuthorId $identifier;
    public readonly Name $name;

    /** 
     * @param array<int,Translate> $translates 
     * @param array<int,ArticleId> $articles 
     * @param array<int,ImageId> $images 
     * */
    public function __construct(
        string $id,
        string $name,
        public readonly bool $active,
        public readonly array $translates,
        public readonly array $articles,
        public readonly array $images,
    ) {
        $this->identifier = new AuthorId($id);
        $this->name = new Name($name);
    }
}
