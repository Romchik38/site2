<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\AdminView\View;

use Romchik38\Site2\Domain\Category\VO\Description;
use Romchik38\Site2\Domain\Category\VO\Name;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class TranslateDto
{
    public function __construct(
        public readonly LanguageId $language,
        public readonly Name $name,
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
}
