<?php

declare(strict_types=1);

namespace Romchik38\Site2\Router\Http\RouterHeaders;

use Romchik38\Server\Api\Results\Http\HttpRouterResultInterface;
use Romchik38\Server\Routers\Http\RouterHeader;

class Root extends RouterHeader {
    public function setHeaders(HttpRouterResultInterface $result, array $path): void
    {
        $result->setHeaders([
            ['Cache-Control:max-age=604800']
        ]);
    }
}