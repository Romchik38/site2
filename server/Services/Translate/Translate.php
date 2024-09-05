<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Translate;

use Romchik38\Server\Api\Models\DTO\TranslateEntity\TranslateEntityDTOInterface;

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
    protected array|null $hash = null;

    public function __construct(
        protected readonly TranslateStorageInterface $translateStorage,
        protected readonly string $defaultLang,
        protected readonly string $currentLang
    ) {}

    public function __invoke(string $str)
    {

        if ($this->hash === null) {
            $this->hash = $this->translateStorage->getDataByLanguages(
                [$this->defaultLang, $this->currentLang]
            );
        }

        /** @var TranslateEntityDTOInterface $translateDTO*/
        $translateDTO = $this->hash[$str] ??
            throw new \RuntimeException('invalid trans string');
        $defaultVal = $translateDTO->getPhrase($this->defaultLang) ??
            throw new \RuntimeException('default value for lang ' . $this->defaultLang . ' isn\'t set');
        return $translateDTO->getPhrase($this->currentLang) ?? $defaultVal;
    }
}
