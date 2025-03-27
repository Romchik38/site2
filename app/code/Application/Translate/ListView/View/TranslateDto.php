<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\ListView\View;

use Romchik38\Site2\Domain\TranslateKey\VO\Identifier;

final class TranslateDto
{
    public function __construct(
        public readonly Identifier $identifier,
    ) {
    }
}
