<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Translate;

// $hash = [
//     'login.index.h1' => [
//         'en' => 'Hello world',
//         'uk' => 'Привіт світ'
//     ]
// ];

// $__ = new A($hash, 'en', 'uk');

// echo $__('login.index.h1');


class Translate implements TranslateInterface
{
    public function __construct(
        protected readonly array $hash,
        protected readonly string $defaultLang,
        protected readonly string $currentLang
    ) {}

    public function __invoke(string $str)
    {
        $item = $this->hash[$str] ??
            throw new \RuntimeException('invalid trans string');
        $defaultVal = $item[$this->defaultLang] ??
            throw new \RuntimeException('default value for lang ' . $this->defaultLang . ' isn\'t set');
        return $item[$this->currentLang] ?? $defaultVal;
    }
}
