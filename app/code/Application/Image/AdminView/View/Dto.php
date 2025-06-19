<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView\View;

use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Name as ImageName;
use Romchik38\Site2\Domain\Image\VO\Path;

final class Dto
{
    /**
     * @param array<int,ArticleDto> $articles
     * @param array<int,AuthorDto> $authors
     * @param array<int,BannerDto> $banners
     * @param array<int,TranslateDto> $translates
     * */
    public function __construct(
        public readonly Id $identifier,
        public readonly bool $active,
        public readonly ImageName $name,
        public readonly Path $path,
        public readonly AuthorDto $author,
        public readonly array $translates,
        public readonly array $articles,
        public readonly array $authors,
        public readonly array $banners,
    ) {
    }
}
