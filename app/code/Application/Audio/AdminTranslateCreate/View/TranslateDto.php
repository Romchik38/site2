<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminTranslateCreate\View;

use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;
use Romchik38\Site2\Domain\Audio\VO\Name;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final readonly class TranslateDto
{
    public function __construct(
        public AudioId $audioId,
        public LanguageId $language,
        public Name $name
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

    public function getName(): string
    {
        return (string) $this->name;
    }
}
