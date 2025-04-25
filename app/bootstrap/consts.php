<?php

declare(strict_types=1);

use Romchik38\Container\Container;

return function (Container $container) {

    function readFolder(string $dir): array {
        $files = [];
        $fileNames = [];
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file === '.' || $file === '..' ) {
                        continue;
                    }
                    $fullPath = $dir . '/' . $file;
                    if (is_dir($fullPath)) {
                        $fileNames = array_merge($fileNames, readFolder($fullPath));
                    } else {
                        $files[] = $fullPath;
                    }
                }
                closedir($dh);
            }
        }
        return array_merge($files, $fileNames);
    };
    
    $dir = __DIR__ . '/../config';
    $configFiles = readFolder($dir);
    $configs = [];
    foreach ($configFiles as $configFile) {
        $config = require $configFile;
        $configs = array_merge($configs, $config);
    }


    //$configImg = require __DIR__ . '/../config/shared/images.php';
    //$configAudio = require __DIR__ . '/../config/shared/audio.php';

    //$configs = array_merge($configImg, $configAudio);

    foreach($configs as $key => $val) {
        $container->add($key, $val);
    }

    return $container;
};
