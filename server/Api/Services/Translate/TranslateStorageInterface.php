<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Translate;

interface TranslateStorageInterface
{

    /**
     * get all data by provided languages
     * 
     * @param string[] $languages ['en', ...]
     * @return 
     */
    public function getDataByLanguages(array $languages): array;
}
