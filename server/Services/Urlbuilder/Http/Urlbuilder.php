<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Urlbuilder\Http;

use Romchik38\Server\Api\Services\Urlbuilder\UrlbuilderInterface;

class Urlbuilder implements UrlbuilderInterface
{
    protected readonly string $prefix;

    public function __construct(
        protected readonly array $path,
        protected readonly string $language
    ) {
        $url = [...$path];
        $url[0] = $language;
        $this->prefix = sprintf(
            '/%s',
            implode('/', $url)
        );
    }

    public function prefix(): string
    {
        return $this->prefix;
    }

    public function add(string $part): string
    {
        return sprintf('%s%s', $this->prefix, $part);
    }
}
