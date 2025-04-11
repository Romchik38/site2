<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio\Entities;

use Romchik38\Site2\Domain\Audio\VO\Description;
use Romchik38\Site2\Domain\Audio\VO\Path;
use Romchik38\Site2\Domain\Language\VO\Identifier;

final class Translate
{
    private Content $content;

    public bool $isContentLoaded = false;

    public function __construct(
        public readonly Identifier $language,
        public readonly Description $description,
        private Path $path
    ) {
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function getContent(): ?Content
    {
        if ($this->isContentLoaded === true) {
            return $this->content;
        } else {
            return null;
        }
    }

    public function getLanguage(): Identifier
    {
        return $this->language;
    }

    /** @todo test */
    public function getPath(): Path
    {
        return $this->path;
    }

    public function loadContent(Content $content): void
    {
        $this->content         = $content;
        $this->isContentLoaded = true;
    }
}
