<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\FileLoader;

use Romchik38\Server\Api\Services\FileLoaderInterface;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Server\Services\Errors\FileLoaderException;

class FileLoader implements FileLoaderInterface
{
    protected string $data = '';

    /** 
     * A path without trailing slash. Something like /some/path/to
     */
    protected readonly string $prefix;

    public function __construct(string $prefix)
    {
        if (!is_dir($prefix)) {
            throw new InvalidArgumentException(sprintf(
                'File dir %s not exist',
                $prefix
            ));
        }

        if (str_ends_with($prefix, '/')) {
            $this->prefix = substr($prefix, 0, strlen($prefix) - 1);
        } else {
            $this->prefix = $prefix;
        }
    }

    public function load(string $path): string
    {
        if (str_starts_with($path, '/')) {
            $fullPath = $this->prefix . $path;
        } else {
            $fullPath = sprintf('%s/%s', $this->prefix, $path);
        }

        if (!file_exists($fullPath)) {
            throw new FileLoaderException(sprintf(
                'File %s not exist',
                $fullPath
            ));
        }

        $fp = fopen($fullPath, 'r');

        if ($fp === false) {
            throw new FileLoaderException(
                sprintf(
                    'Can\'t open to read file %s',
                    $fullPath
                )
            );
        }

        $file = '';

        $chank = fread($fp, 1024);
        while ($chank !== false && $chank !== '') {
            if ($chank !== false) {
                $file .= $chank;
            }
            $chank = fread($fp, 1024);
        }

        fclose($fp);

        if (strlen(trim($file)) === 0) {
            throw new FileLoaderException(
                sprintf(
                    'File is empty %s',
                    $fullPath
                )
            );
        }

        return $file;
    }
}
