<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminView\Dto;

use DateTime;
use Romchik38\Site2\Domain\Article\VO\Description;
use Romchik38\Site2\Domain\Article\VO\Name;
use Romchik38\Site2\Domain\Article\VO\ShortDescription;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class Translate
{
    public const DATE_FORMAT = 'G:i  d-m-y';

    public function __construct(
        public readonly LanguageId $language,
        public readonly Name $name,
        public readonly ShortDescription $shortDescription,
        public readonly Description $description,
        public readonly DateTime $createdAt,
        public readonly DateTime $updatedAt
    ) {
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt->format(self::DATE_FORMAT);
    }

    public function getDescription(): string
    {
        return (string) $this->description;
    }

    public function getLanguage(): string
    {
        return (string) $this->language;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function getShortDescription(): string
    {
        return (string) $this->shortDescription;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt->format(self::DATE_FORMAT);
    }
}
