<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminList\View;

use DateTime;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Author\VO\Name as AuthorName;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;

final readonly class ArticleDto
{
    public const DATE_FORMAT = 'd-m-Y';

    public function __construct(
        public ArticleId $identifier,
        public bool $active,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public bool|null $imgActive,
        public ImageId|null $imgIdentifier,
        public bool|null $audioActive,
        public AuthorName $authorName
    ) {
    }

    public function formatCreatedAt(): string
    {
        return $this->createdAt->format(self::DATE_FORMAT);
    }

    public function formatUpdatedAt(): string
    {
        return $this->updatedAt->format(self::DATE_FORMAT);
    }

    public function getAuthorName(): string
    {
        return (string) $this->authorName;
    }

    public function getId(): string
    {
        return (string) $this->identifier;
    }
}
