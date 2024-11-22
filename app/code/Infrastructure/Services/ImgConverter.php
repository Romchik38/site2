<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services;

use Romchik38\Site2\Application\ImgConverter\ImgConverterInterface;
use Romchik38\Site2\Infrastructure\Services\ImgConverter\Image;

class ImgConverter implements ImgConverterInterface
{
    protected array $capabilities = [
        'webp' => 'WebP Support'
    ];

    public function __construct()
    {
        if (extension_loaded('gd') === false) {
            throw new \RuntimeException('GD extension not loaded');
        }
    }

    public function create(Image $img): string {

        if ($this->checkGDcapabilities($img->originalType) === false) {
            throw new \RuntimeException(sprintf(
                'GD library do not support type %',
                $img->originalType
            ));
        };

        if ($this->checkGDcapabilities($img->copyType) === false) {
            throw new \RuntimeException(sprintf(
                'GD library do not support type %',
                $img->copyType
            ));
        };

        return '';
    }

    protected function checkGDcapabilities(string $type): bool
    {
        $info = gd_info();
        $key = $this->capabilities[$type] ?? null;
        if (is_null($key)) {
            throw new \RuntimeException(sprintf('Type %s not supported by converter'));
        }
        $capability = $info[$key] ?? null;
        if (is_null($capability)) {
            throw new \RuntimeException(
                sprintf(
                    'ImgConverter internal error. Capability %s is expected, but not found',
                    $key
                )
            );
        }
        return $capability;
    }
}
