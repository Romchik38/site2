<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\View\View;

use Romchik38\Site2\Domain\Language\VO\Identifier;
use Romchik38\Site2\Domain\Translate\VO\Text;

final class PhraseDto
{
    public function __construct(
        public readonly Identifier $language,
        public readonly Text $text
    ) {
    }

    public function getLanguage(): string
    {
        return (string)$this->language;
    }

    public function getText(): string
    {
        return (string)$this->text;
    }
}
