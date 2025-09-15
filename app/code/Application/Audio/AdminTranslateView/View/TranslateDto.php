<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminTranslateView\View;

use Romchik38\Site2\Domain\Audio\VO\Description;
use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;
use Romchik38\Site2\Domain\Audio\VO\Path;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final readonly class TranslateDto
{
    public function __construct(
        public AudioId $audioId,
        public LanguageId $language,
        public Description $description,
        public Path $path
    ) {
    }

    public function getAudioId(): string
    {
        return (string) $this->audioId;
    }

    public function getLanguage(): string
    {
        return (string) $this->language;
    }

    public function getDescription(): string
    {
        return (string) $this->description;
    }

    public function getPath(): string
    {
        return (string) $this->path;
    }
}
