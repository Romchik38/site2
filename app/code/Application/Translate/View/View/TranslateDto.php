<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\View\View;

use Romchik38\Site2\Domain\Translate\VO\Identifier;

final readonly class TranslateDto
{
    /** @param array<int,PhraseDto> $phrases */
    public function __construct(
        public Identifier $identifier,
        public array $phrases
    ) {
    }
}
