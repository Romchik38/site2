<?php

declare(strict_types=1);

namespace Romchik38\Server\Routers\Http;

use Romchik38\Server\Api\Router\Http\RouterHeadersInterface;
use Romchik38\Server\Api\Routers\Http\DynamicHeadersCollectionInterface;

/** 
 * this is not a service for the app
 * it used only in dynamic header
 */
class DynamicHeadersCollection implements DynamicHeadersCollectionInterface
{
    protected array $hash = [];

    public function __construct(
        array $data
    ) {
        foreach ($data as $method => $headerList) {
            $headers = [];
            foreach ($headerList as $path => $header) {
                $headers[$path] = $header;
            }
            $hash[$method] = $headers;
        }
    }

    public function getHeader(string $method, string $path): RouterHeadersInterface|null
    {
        $headers = $hash[$method] ?? null;
        if ($headers === null) {
            return null;
        }

        $header = $headers[$path] ?? null;

        return $header;
    }
}
