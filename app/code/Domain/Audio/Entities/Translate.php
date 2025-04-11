<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio\Entities;

use Romchik38\Site2\Domain\Audio\VO\Description;
use Romchik38\Site2\Domain\Language\VO\Identifier;

final class Translate
{
    private Content $content;

    /** @todo test */
    public bool $isLoaded = false;

    public function __construct(
        public readonly Identifier $language,
        public readonly Description $description
    ) {
    }

    /** @todo test */    
    public function getLanguage(): Identifier
    {
        return $this->language;
    }

    /** @todo test */
    public function getDescription(): Description
    {
        return $this->description;
    }

    /** @todo test */
    public function getContent(): ?Content
    {
        if ($this->isLoaded === true) {
            return $this->content;
        } else {
            return null;
        }
    }

    /** @todo test */
    public function loadContent(Content $content): void
    {
        $this->content  = $content;
        $this->isLoaded = true;
    }
}
