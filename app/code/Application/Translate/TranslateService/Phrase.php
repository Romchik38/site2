<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\TranslateService;

final class Phrase
{
    public function __construct(
        public readonly string $language,
        public readonly string $phrase
    ) {
    }
}
