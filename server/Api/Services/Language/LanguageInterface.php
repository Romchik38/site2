<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Services\Language;

use Romchik38\Server\Api\Models\DTO\Language\LanguageDTOInterface;

interface LanguageInterface
{
    const DEFAULT_LANGUAGE_FIELD = 'default_language';
    const LANGUAGE_LIST_FIELD = 'language_list';

    /** return language entity */
    public function getDefaultLanguage(): LanguageDTOInterface;

    /** 
     * return a list of language entities
     * see list in the config file
     * 
     * @return LanguageDTOInterface[]
     */
    public function getLanguageList(): array;
}
