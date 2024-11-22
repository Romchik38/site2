<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services;

class ImgConverter
{
    protected array $catabilities = [
        'webp' => 'WebP Support'
    ];

    public function __construct()
    {
        if (extension_loaded('gd') === false) {
            throw new \RuntimeException('GD extension not loaded');
        }
    }

    public function create(
        string $data,
        string $type,
        float $aspect,
        int $size
    ): string {

        if ($this->checkGDcapabilities($type) === false) {
            throw new \RuntimeException(sprintf(
                'GD library do not support type %',
                $type
            ));
        };

        return '';
    }

    protected function checkGDcapabilities(string $type): bool
    {
        $info = gd_info();
        $key = $this->catabilities[$type] ?? null;
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
