<?php

declare(strict_types=1);

namespace Romchik38\Site2\Router\Http\RouterHeaders;

use Romchik38\Server\Api\Results\Http\HttpRouterResultInterface;
use Romchik38\Server\Api\Router\Http\RouterHeadersInterface;

class Root implements RouterHeadersInterface {
    public function setHeaders(HttpRouterResultInterface $result, array $path): void
    {
        $a = 1;
        
    }
}