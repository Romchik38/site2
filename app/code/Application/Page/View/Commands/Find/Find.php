<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\View\Commands\Find;

final class Find
{
    public function __construct(
        public readonly string $url,
        public readonly string $language
    ) {
    }
}
