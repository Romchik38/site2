<?php

declare(strict_types=1);

use Romchik38\Container\Container;

return function (Container $container) {

    $configImg = require __DIR__ . '/../config/shared/images.php';
    $configImgFolderBackend =  $configImg['img-folder-backend'];

    $container->add('image.path-prefix', $configImgFolderBackend);


    return $container;
};
