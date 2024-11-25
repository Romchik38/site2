<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleView\View;

final class AudioDTO
{
    public function __construct(
        public readonly string $path,
        public readonly string $description
    ) {}
}
