<?php

declare(strict_types=1);

return function ($container) {

    // REQUEST
    $container->add(
        \Romchik38\Server\Services\Request\Http\Request::class,
        new \Romchik38\Server\Services\Request\Http\Request(
            $container->get(\Romchik38\Server\Api\Services\Request\Http\UriFactoryInterface::class)    
        )
    );
    $container->add(
        \Romchik38\Server\Api\Services\Request\Http\RequestInterface::class,
        $container->get(\Romchik38\Server\Services\Request\Http\Request::class)
    );

    return $container;
};