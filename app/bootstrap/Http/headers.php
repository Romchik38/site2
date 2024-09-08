<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Router\Http\HttpRouterInterface;
use Romchik38\Server\Api\Routers\Http\DynamicHeadersCollectionInterface;
use Romchik38\Server\Routers\Http\DynamicHeadersCollection;

/** 
 * This is a runtime function.
 * 
 * [!] 
 *   All instances will be created at runtime, 
 *   so you must to check how all classes works
 */
return function (Container $container) {

    $container->add('headers', function ($container) {

        /** the function will be called from dynamic router at runtime */
        return function (string $rootName) use ($container): DynamicHeadersCollectionInterface {

            $s = ControllerInterface::PATH_SEPARATOR;
            $a = ControllerInterface::PATH_DYNAMIC_ALL;
            $arr = [];

            // GET
            $arr[HttpRouterInterface::REQUEST_METHOD_GET] = [
                /** en => header root instance */
                $rootName => new Romchik38\Site2\Router\Http\RouterHeaders\Root()
            ];

            return new DynamicHeadersCollection($arr);
        };
    });

    return $container;
};
