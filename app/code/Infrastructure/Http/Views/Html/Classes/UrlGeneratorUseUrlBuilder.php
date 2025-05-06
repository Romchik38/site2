<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html\Classes;

use Romchik38\Server\Controllers\PathInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Infrastructure\Http\Views\Html\UrlGeneratorInterface;

final class UrlGeneratorUseUrlBuilder implements UrlGeneratorInterface
{
    public function __construct(
        private readonly PathInterface $path,
        private readonly UrlbuilderInterface $urlBuilder,
    ) {
    }

    public function generateUrl(array $queries): string
    {
        $params = [];
        foreach ($queries as $query) {
            $params[$query->key] = (string) $query->value;
        }

        return $this->urlBuilder->fromPath($this->path, $params);
    }
}
