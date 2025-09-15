<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminView\Dto;

use Romchik38\Site2\Domain\Audio\VO\Description;
use Romchik38\Site2\Domain\Audio\VO\Path;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final readonly class AudioTranslateDto
{
    public function __construct(
        public LanguageId $language,
        public Description $description,
        public Path $path
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

    public function getPath(): string
    {
        return (string) $this->path;
    }
}
