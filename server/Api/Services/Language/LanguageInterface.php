<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Language;

interface LanguageInterface
{
    const DEFAULT_LANGUAGE_FIELD = 'default_language';
    const LANGUAGE_LIST_FIELD = 'language_list';

    public function getDefaultLanguage(): string;
    public function getLanguageList(): array;
}
