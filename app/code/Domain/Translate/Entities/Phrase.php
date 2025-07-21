<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Translate\Entities;

use Romchik38\Site2\Domain\Language\VO\Identifier;
use Romchik38\Site2\Domain\Translate\VO\Text;

final class Phrase
{
    public function __construct(
        public readonly Identifier $language,
        public readonly Text $text
    ) {
    }

    public function getLanguage(): Identifier
    {
        return $this->language;
    }
}
