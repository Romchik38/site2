<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ContinueReading\Commands\Update;

final class Update
{
    public function __construct(
        public readonly string $articleId,
        public readonly string $languageId
    ) {
    }
}
