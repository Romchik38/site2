<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminList\View;

use DateTime;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Id;

final class ArticleDto
{
    public const DATE_FORMAT = 'd-m-Y';

    public readonly ArticleId $identifier;
    public readonly Name $authorName;

    public function __construct(
        string $identifier,
        public readonly bool $active,
        public readonly DateTime $createdAt,
        public readonly DateTime $updatedAt,
        public readonly bool|null $imgActive,
        public readonly Id|null $imgIdentifier,
        public readonly bool|null $audioActive,
        string $authorName
    ) {
        $this->identifier = new ArticleId($identifier);

        $this->authorName = new Name($authorName);
    }

    public function formatCreatedAt(): string
    {
        return $this->createdAt->format(self::DATE_FORMAT);
    }

    public function formatUpdatedAt(): string
    {
        return $this->updatedAt->format(self::DATE_FORMAT);
    }
}
