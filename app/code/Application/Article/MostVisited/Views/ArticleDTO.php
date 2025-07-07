<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\MostVisited\Views;

use DateTime;
use Romchik38\Site2\Domain\Article\VO\Description;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Name;
use Romchik38\Site2\Domain\Article\VO\Views;

final class ArticleDTO
{
    public function __construct(
        public readonly ArticleId $id,
        public readonly Name $name,
        public readonly Description $description,
        public readonly DateTime $createdAt,
        public readonly Views $views,
        public readonly ImageDTO $image
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
