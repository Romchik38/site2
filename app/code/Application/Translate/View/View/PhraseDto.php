<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\View\View;

use Romchik38\Site2\Domain\Language\VO\Identifier;
use Romchik38\Site2\Domain\Translate\VO\Phrase;

final class PhraseDto 
{
    public function __construct(
        public readonly Identifier $language,
        public readonly Phrase $phrase
    ) {
    }

    public function getLanguage(): Identifier
    {
        return $this->language;
    }

    public function getPhrase(): Phrase
    {
        return $this->phrase;
    }
}
