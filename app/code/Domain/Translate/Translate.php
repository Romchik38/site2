<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Translate;

use Romchik38\Site2\Domain\Translate\VO\Identifier;

final class Translate
{
    public function __construct(
        public Identifier $identifier
    ) {
    }
}