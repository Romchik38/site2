<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html\Classes;

use InvalidArgumentException;
use Romchik38\Server\Http\Controller\PathInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Infrastructure\Http\Views\Html\UrlGeneratorInterface;

final class UrlGeneratorUseUrlBuilder implements UrlGeneratorInterface
{
    public function __construct(
        private readonly PathInterface $path,
        private readonly UrlbuilderInterface $urlBuilder,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * @param array<int,mixed|Query> $queries
     * */
    public function generateUrl(array $queries): string
    {
        $params = [];
        foreach ($queries as $query) {
            if (! $query instanceof Query) {
                throw new InvalidArgumentException('param query is invalid');
            }
            $params[$query->key] = (string) $query->value;
        }

        return $this->urlBuilder->fromPath($this->path, $params);
    }
}
