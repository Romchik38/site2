<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\View\View;

use Romchik38\Site2\Domain\Translate\VO\Identifier;

final class TranslateDto
{
    /** @param array<int,PhraseDto> $phrases */
    public function __construct(
        public readonly Identifier $identifier,
        public readonly array $phrases
    ) {
    }
}
