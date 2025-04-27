<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Language\List\View;

use Romchik38\Site2\Domain\Language\VO\Identifier;

final class LanguageDto
{
    public function __construct(
        public readonly Identifier $identifier,
        public readonly bool $active
    ) {
    }
}
