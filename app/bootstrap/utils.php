<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;

return function (Container $container) {
    // LOGGER
    $container->multi(
        '\Romchik38\Server\Utils\Logger\DeferredLogger\FileLogger',
        '\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface',
        true,
        [
            __DIR__ . '/../var/file.log',
            7,
        ]
    );

    // URLBUILDER
    $container->multi(
        '\Romchik38\Server\Http\Utils\Urlbuilder\Urlbuilder',
        '\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface',
        true,
        [
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\DynamicTarget'),
        ]
    );

    $container->shared('\Romchik38\Server\Http\Utils\Urlbuilder\DynamicTarget', [
        new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
    ]);

    // CSRF TOKEN GENERATOR
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorUseRandomBytes',
        '\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface',
        true,
        [32]
    );

    // BREADCRAMB
    $container->shared(
        '\Romchik38\Server\Http\Controller\Mappers\Breadcrumb\Breadcrumb',
        [
            new Promise('\Romchik38\Server\Http\Controller\Mappers\ControllerTree\ControllerTree'),
            new promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
        ]
    );

    // CONTROLLER TREE
    $container->shared('\Romchik38\Server\Http\Controller\Mappers\ControllerTree\ControllerTree');

    // LINK TREE
    $container->multi(
        '\Romchik38\Server\Http\Controller\Mappers\LinkTree\LinkTree',
        '\Romchik38\Server\Http\Controller\Mappers\LinkTree\LinkTreeInterface',
        true,
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
        ]
    );

    $container->multi(
        '\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRoot',
        '\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface',
        true,
        [
            new Promise(DynamicRootInterface::DEFAULT_ROOT_FIELD),
            new Promise(DynamicRootInterface::ROOT_LIST_FIELD),
        ]
    );

    // TRANSLATE
    $container->multi(
        '\Romchik38\Server\Utils\Translate\TranslateUseDynamicRoot',
        '\Romchik38\Server\Utils\Translate\TranslateInterface',
        true,
        [
            new Promise('\Romchik38\Server\Utils\Translate\TranslateStorageInterface'),
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    return $container;
};