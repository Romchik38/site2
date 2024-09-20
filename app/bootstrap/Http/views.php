<?php

declare(strict_types=1);

use Romchik38\Container;

return function(Container $container) {

    $twigConfig = require_once(__DIR__ . '/../../config/shared/twig.php');

    // Loader
    $loaderConfig = $twigConfig[\Twig\Loader\FilesystemLoader::class];
    $container->add(
        \Twig\Loader\FilesystemLoader::class,
        new \Twig\Loader\FilesystemLoader(
            $loaderConfig['path']
        )
    );

    // Environment
    $container->add(
        \Twig\Environment::class,
        new \Twig\Environment(
            $container->get(\Twig\Loader\FilesystemLoader::class)
            // ? cache
        )
    );

    // Twig Default View
    $container->add(
        \Romchik38\Server\Views\Http\TwigView::class,
        new \Romchik38\Server\Views\Http\TwigView(
            $container->get(\Twig\Environment::class),
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class)
        )
    );

    return $container;
};