<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\SimilarArticles\View;

use DateTime;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Name;
use Romchik38\Site2\Domain\Article\VO\ShortDescription;

final readonly class ArticleDto
{
    public function __construct(
        public ArticleId $id,
        public Name $name,
        public ShortDescription $shortDescription,
        public DateTime $createdAt,
        public ImageDto $image
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function getShortDescription(): string
    {
        return (string) $this->shortDescription;
    }
}
