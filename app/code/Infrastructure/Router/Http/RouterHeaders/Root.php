<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Router\Http\RouterHeaders;

use Romchik38\Server\Api\Results\Http\HttpRouterResultInterface;
use Romchik38\Server\Routers\Http\RouterHeader;

final class Root extends RouterHeader {

    /**
     * @param string[] $path
     */
    public function setHeaders(HttpRouterResultInterface $result, array $path): void
    {
        $result->setHeaders([
            ['Cache-Control:max-age=604800']
        ]);
    }
}