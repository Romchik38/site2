<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView\View;

use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Name as ImageName;
use Romchik38\Site2\Domain\Image\VO\Path;

final readonly class Dto
{
    /**
     * @param array<int,ArticleDto> $articles
     * @param array<int,AuthorDto> $authors
     * @param array<int,BannerDto> $banners
     * @param array<int,TranslateDto> $translates
     * */
    public function __construct(
        public Id $identifier,
        public bool $active,
        public ImageName $name,
        public Path $path,
        public AuthorDto $author,
        public array $translates,
        public array $articles,
        public array $authors,
        public array $banners,
    ) {
    }

    public function getId(): string
    {
        return (string) $this->identifier;
    }

    public function getImageName(): string
    {
        return (string) $this->name;
    }

    public function getPath(): string
    {
        return (string) $this->path;
    }
}
