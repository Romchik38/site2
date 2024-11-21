<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Services\Request\Http\ServerRequestService;
use Romchik38\Server\Services\Request\Http\UriFactory;

return function () {
    $container = new Container();

    $configDatabase = require_once(__DIR__ . '/config/private/database.php');

    // DATABASES
    $container->add(
        \Romchik38\Server\Models\Sql\DatabasePostgresql::class,
        new \Romchik38\Server\Models\Sql\DatabasePostgresql($configDatabase)
    );
    $container->add(
        \Romchik38\Server\Api\Models\DatabaseInterface::class,
        $container->get(\Romchik38\Server\Models\Sql\DatabasePostgresql::class)
    );

    // Request
    $container->add(
        \Romchik38\Server\Services\Request\Http\ServerRequest::class,
        new \Romchik38\Server\Services\Request\Http\ServerRequest(
            new UriFactory,
            new ServerRequestService
        )
    );
    $container->add(
        \Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface::class,
        $container->get(\Romchik38\Server\Services\Request\Http\ServerRequest::class)
    );

    // ImgViewRepository
    $container->add(
        Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ImgConverter\ImgViewRepository::class,
        new Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ImgConverter\ImgViewRepository(
            $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
        )
    );
    $container->add(
        \Romchik38\Site2\Application\ImgConverter\View\ImgViewRepositoryInterface::class,
        $container->get(Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ImgConverter\ImgViewRepository::class)
    );

    // ImgConverterService
    $container->add(
        Romchik38\Site2\Application\ImgConverter\ImgConverterService::class,
        new Romchik38\Site2\Application\ImgConverter\ImgConverterService(
            $container->get(\Romchik38\Site2\Application\ImgConverter\View\ImgViewRepositoryInterface::class)
        )
    );

    return $container;
};