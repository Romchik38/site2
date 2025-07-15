<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\PageService\Commands;

use function is_string;

final class Create
{
    public const URL_FIELD = 'url';

    private function __construct(
        public readonly string $url
    ) {
    }

    /** @param array<string,mixed> $hash */
    public static function formHash(array $hash): self
    {
        $url    = '';
        $rawUrl = $hash[self::URL_FIELD] ?? '';
        if (is_string($rawUrl)) {
            $url = $rawUrl;
        }

        return new self($url);
    }
}
