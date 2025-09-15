<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminView\View;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name;

final readonly class AuthorDto
{
    /** @var array<int,ArticleDto> */
    public array $articles;

    /** @var array<int,ImageDto> */
    public array $images;

    /**
     * @throws InvalidArgumentException
     * @param array<int,Translate> $translates
     * @param array<int,mixed|ArticleDto> $articles
     * @param array<int,mixed|ImageDto> $images
     * */
    public function __construct(
        public AuthorId $identifier,
        public Name $name,
        public bool $active,
        public array $translates,
        array $articles,
        array $images,
    ) {
        foreach ($articles as $article) {
            if (! $article instanceof ArticleDto) {
                throw new InvalidArgumentException('Param article is invalid');
            }
        }
        $this->articles = $articles;
        foreach ($images as $image) {
            if (! $image instanceof ImageDto) {
                throw new InvalidArgumentException('Param image is invalid');
            }
        }
        $this->images = $images;
    }
}
