<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Api\ArticleContinueReading\DefaultAction;

final class Item
{
    public function __construct(
        public string $first,
        public ?string $second = null
    ) {
    }
}
