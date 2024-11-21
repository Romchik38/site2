<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Services;

interface FileLoaderInterface
{
    /** 
     * @throws FileLoaderException on any error during loading process
     */
    public function load(string $path): string;
}
