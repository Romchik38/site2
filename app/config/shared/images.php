<?php

declare(strict_types=1);

/** 
 * All images
 */
return [
    'img-cache-control-header' => 'max-age=86400', // set null if not used
    'img-cache-enabled' => false,
    'img-max-cache-size' => 999_000_000, // 1GB,
    'img-folder-frontend' => '/media/img', // Path to public html img folder
    'img-folder-backend' => __DIR__ . '/../../../public/http/media/img',
];