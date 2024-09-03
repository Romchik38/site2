<?php 

declare(strict_types=1);

use Romchik38\Container;

return function(){
    $container = new Container();

    $actions = include_once(__DIR__  . '/bootstrap/actions.php');
    $actions($container);
    
    $actionList = include_once(__DIR__  . '/bootstrap/Http/actionsList.php');
    $actionList($container);
    
    return $container;
};

