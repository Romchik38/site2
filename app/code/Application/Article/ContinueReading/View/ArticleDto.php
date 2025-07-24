<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ContinueReading\View;

use DateTime;
use JsonSerializable;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Name;
use Romchik38\Site2\Domain\Article\VO\ShortDescription;

final class ArticleDto implements JsonSerializable
{
    public const CREATED_AT_FORMAT = 'j-n-y';

    public function __construct(
        public readonly ArticleId $id,
        public readonly Name $name,
        public readonly ShortDescription $shortDescription,
        public readonly DateTime $createdAt,
        public readonly ImageDto $image
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'article_id'                => ($this->id)(),
            'article_name'              => ($this->name)(),
            'article_short_description' => ($this->shortDescription)(),
            'article_created_at'        => $this->createdAt->format(self::CREATED_AT_FORMAT),
            'image_id'                  => (string) $this->image->id,
            'image_description'         => ($this->image->description)(),
        ];
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

    public function getCreatedAt(): string
    {
        return $this->createdAt->format(self::CREATED_AT_FORMAT);
    }
}
