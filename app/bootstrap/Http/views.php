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

    return $container;
};