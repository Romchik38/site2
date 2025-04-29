<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;

return function (Container $container) {
    // LOGGER
    $container->multi(
        '\Romchik38\Server\Services\Logger\Loggers\FileLogger',
        '\Romchik38\Server\Api\Services\LoggerServerInterface',
        true,
        [
            __DIR__ . '/../var/file.log',
            7,
        ]
    );

    // URLBUILDER
    $container->multi(
        '\Romchik38\Server\Services\Urlbuilder\Urlbuilder',
        '\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface',
        true,
        [
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\DynamicTarget'),
        ]
    );

    $container->shared('\Romchik38\Server\Services\Urlbuilder\DynamicTarget', [
        new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
    ]);

    // DateFormatter
    $container->shared('\Romchik38\Site2\Infrastructure\Utils\DateFormatterUsesDateFormat', []);
    // ReadLengthFormatter
    $container->shared('\Romchik38\Site2\Infrastructure\Utils\ReadLengthFormatter', [
        new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
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
        '\Romchik38\Server\Services\Mappers\Breadcrumb\Http\Breadcrumb',
        [
            new Promise('\Romchik38\Server\Services\Mappers\ControllerTree\ControllerTree'),
            new promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
        ]
    );

    // CONTROLLER TREE
    $container->shared('\Romchik38\Server\Services\Mappers\ControllerTree\ControllerTree');

    // LINK TREE
    $container->multi(
        '\Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree',
        '\Romchik38\Server\Api\Services\Mappers\LinkTree\Http\LinkTreeInterface',
        true,
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
        ]
    );

    // REQUEST
    $container->add(
        '\Psr\Http\Message\ServerRequestInterface',
        Laminas\Diactoros\ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        )
    );

    // SESSION
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2Session',
        '\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface',
        true,
        []
    );

    $container->multi(
        '\Romchik38\Server\Services\DynamicRoot\DynamicRoot',
        '\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface',
        true,
        [
            new Promise(DynamicRootInterface::DEFAULT_ROOT_FIELD),
            new Promise(DynamicRootInterface::ROOT_LIST_FIELD),
        ]
    );

    // TRANSLATE
    $container->multi(
        '\Romchik38\Server\Services\Translate\TranslateUseDynamicRoot',
        '\Romchik38\Server\Services\Translate\TranslateInterface',
        true,
        [
            new Promise('\Romchik38\Server\Services\Translate\TranslateStorageInterface'),
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
        ]
    );

    return $container;
};