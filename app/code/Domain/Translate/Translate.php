<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\TranslateKey;

use Romchik38\Site2\Domain\TranslateKey\VO\Identifier;

final class Translate
{
    public function __construct(
        public Identifier $identifier
    ) {
    }
}