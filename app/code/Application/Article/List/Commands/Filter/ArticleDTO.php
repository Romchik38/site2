<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\List\Commands\Filter;

use DateTime;
use Romchik38\Site2\Domain\Article\VO\Description;
use Romchik38\Site2\Domain\Article\VO\Identifier;
use Romchik38\Site2\Domain\Article\VO\Name;
use Romchik38\Site2\Domain\Article\VO\ShortDescription;

final class ArticleDTO
{
    /** @param CategoryDTO[] $categories */
    public function __construct(
        public readonly Identifier $articleId,
        public readonly Name $name,
        public readonly ShortDescription $shortDescription,
        public readonly Description $description,
        public readonly array $categories,
        public readonly DateTime $createdAt,
        public readonly ImageDTO $image
    ) {
    }

    public function getId(): string
    {
        return (string) $this->articleId;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function getDescription(): string
    {
        return (string) $this->description;
    }

    public function getShortDescription(): string
    {
        return (string) $this->shortDescription;
    }
}
