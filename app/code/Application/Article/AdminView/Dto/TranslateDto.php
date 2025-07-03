<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminView\Dto;

use Romchik38\Site2\Domain\Article\VO\Description;
use Romchik38\Site2\Domain\Article\VO\Name;
use Romchik38\Site2\Domain\Article\VO\ShortDescription;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class TranslateDto
{
    public function __construct(
        public readonly LanguageId $language,
        public readonly Name $name,
        public readonly ShortDescription $shortDescription,
        public readonly Description $description
    ) {
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
}
