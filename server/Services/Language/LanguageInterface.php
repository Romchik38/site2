<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Language;

use Romchik38\Server\Api\Models\DTO\Language\LanguageDTOFactoryInterface;
use Romchik38\Server\Api\Models\DTO\Language\LanguageDTOInterface;
use Romchik38\Server\Api\Services\Language\LanguageInterface;

class Language implements LanguageInterface
{
    protected readonly LanguageDTOInterface $defaultLanguage;
    protected readonly array $laguageList;

    public function __construct(
        string $defaultLanguage,
        array $laguageList,
        LanguageDTOFactoryInterface $languageDTOFactory
    ) {
        $this->defaultLanguage = $languageDTOFactory->create($defaultLanguage);
        $list = [];
        foreach ($laguageList as $languageName) {
            $languageDTO = $languageDTOFactory->create($languageName);
            $list[] = $languageDTO;
        }
        $this->laguageList = $list;
    }

    public function getDefaultLanguage(): LanguageDTOInterface
    {
        return $this->defaultLanguage;
    }

    public function getLanguageList(): array
    {
        return $this->laguageList;
    }
}
