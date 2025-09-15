<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\MostVisited\Views;

use DateTime;
use Romchik38\Site2\Domain\Article\VO\Description;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Name;
use Romchik38\Site2\Domain\Article\VO\Views;

final readonly class ArticleDTO
{
    public function __construct(
        public ArticleId $id,
        public Name $name,
        public Description $description,
        public DateTime $createdAt,
        public Views $views,
        public ImageDTO $image
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

    public function getDescription(): string
    {
        return (string) $this->description;
    }

    public function getViews(): string
    {
        return (string) $this->views;
    }
}
