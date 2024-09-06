<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Translate;

use Romchik38\Server\Api\Models\DTO\TranslateEntity\TranslateEntityDTOInterface;
use Romchik38\Server\Api\Services\DymanicRoot\DymanicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Services\Translate\TranslateStorageInterface;

/**
 * Translate a string by given key. Just pass the key 
 * like in the example below:
 *      $__ = new Translate($translateStorage, $dymanicRoot);
 *      echo $__('login.index.h1');
 * 
 * Returns translated string for current language, 
 *   otherwise returns the string for default language
 *   otherwise throws an error (so the key must be in the translate storage)
 * 
 */
class Translate implements TranslateInterface
{
    protected string $defaultLang;
    protected string $currentLang;

    protected array|null $hash = null;

    public function __construct(
        protected readonly TranslateStorageInterface $translateStorage,
        protected readonly DymanicRootInterface $dymanicRoot
    ) {
        $this->defaultLang = $this->dymanicRoot->getDefaultRoot();
    }

    public function __invoke(string $str)
    {
        $currentLang = $currentLang ?? $this->dymanicRoot->getCurrentRoot();

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
