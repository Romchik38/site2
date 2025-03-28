<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Translate\Entities;

use Romchik38\Site2\Domain\Language\VO\Identifier;
use Romchik38\Site2\Domain\Translate\VO\Phrase as PhraseVo;

final class Phrase
{
    public function __construct(
        public readonly Identifier $language,
        public readonly PhraseVo $phrase
    ) {
    }

    public function getLanguage(): Identifier
    {
        return $this->language;
    }

    public function getPhrase(): PhraseVo
    {
        return $this->phrase;
    }
}
