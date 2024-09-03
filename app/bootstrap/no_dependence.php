<?php

declare(strict_types=1);

use Romchik38\Container;


return function(Container $container) {

    // CONTROLLER
    $container->add(
        \Romchik38\Server\Results\Controller\ControllerResultFactory::class,
        new \Romchik38\Server\Results\Controller\ControllerResultFactory()
    );
    $container->add(
        \Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class,
        $container->get(\Romchik38\Server\Results\Controller\ControllerResultFactory::class)    
    );    

    return $container;
};