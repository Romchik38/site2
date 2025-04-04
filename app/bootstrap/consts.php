<?php

declare(strict_types=1);

use Romchik38\Container\Container;

return function (Container $container) {

    $configImg = require __DIR__ . '/../config/shared/images.php';
    $configAudio = require __DIR__ . '/../config/shared/audio.php';

    $configs = array_merge($configImg, $configAudio);

    foreach($configs as $key => $val) {
        $container->add($key, $val);
    }

    return $container;
};
